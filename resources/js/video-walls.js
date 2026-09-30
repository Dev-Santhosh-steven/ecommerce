/**
 * LED & LCD video wall explore pages.
 *
 *  liveScreen    — pins a slideshow onto the screen(s) inside a photo. Each `.vw-screen` carries
 *                  data-quad="x1,y1 x2,y2 x3,y3 x4,y4" (percent of the photo, TL TR BR BL) and is
 *                  mapped with a CSS matrix3d homography so the content sits in true perspective.
 *                  Curved walls use data-box / clip-path instead. Slides cross-fade on a shared clock.
 *  pixelDissolve — swaps images block-by-block, like an LED wall refreshing.
 *  wallBuilder   — LCD video wall configurator (panels, layout, content, size & resolution).
 */

const BASE = 1000; // unit width of a screen element before it is transformed

/** Solve the 8 homography coefficients mapping the unit rectangle onto a quad. */
function homography(w, h, quad) {
    const src = [[0, 0], [w, 0], [w, h], [0, h]];
    const A = [];
    const b = [];
    src.forEach(([x, y], i) => {
        const [X, Y] = quad[i];
        A.push([x, y, 1, 0, 0, 0, -X * x, -X * y]); b.push(X);
        A.push([0, 0, 0, x, y, 1, -Y * x, -Y * y]); b.push(Y);
    });
    // Gaussian elimination with partial pivoting
    const n = 8;
    for (let c = 0; c < n; c++) {
        let p = c;
        for (let r = c + 1; r < n; r++) if (Math.abs(A[r][c]) > Math.abs(A[p][c])) p = r;
        [A[c], A[p]] = [A[p], A[c]];
        [b[c], b[p]] = [b[p], b[c]];
        for (let r = c + 1; r < n; r++) {
            const f = A[r][c] / A[c][c];
            for (let k = c; k < n; k++) A[r][k] -= f * A[c][k];
            b[r] -= f * b[c];
        }
    }
    const h8 = new Array(n);
    for (let r = n - 1; r >= 0; r--) {
        let s = b[r];
        for (let k = r + 1; k < n; k++) s -= A[r][k] * h8[k];
        h8[r] = s / A[r][r];
    }
    const [a, bb, c, d, e, f, g, hh] = h8;
    return `matrix3d(${a},${d},0,${g},${bb},${e},0,${hh},0,0,1,0,${c},${f},0,1)`;
}

const parsePoints = (s) => s.trim().split(/\s+/).map((p) => p.split(',').map(Number));

document.addEventListener('alpine:init', () => {
    const Alpine = window.Alpine;

    Alpine.data('liveScreen', (opts = {}) => ({
        i: 0,
        n: opts.count ?? 1,
        timer: null,

        init() {
            this.layout();
            // re-map when the photo loads, the element is shown (tabs) or the window changes size
            this.ro = new ResizeObserver(() => this.layout());
            // x-ref="host" registers after init, so observe it on the next tick
            this.$nextTick(() => {
                this.layout();
                this.ro.observe(this.$refs.host || this.$el);
            });
            this.onResize = () => this.layout();
            window.addEventListener('resize', this.onResize);
            const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (this.n > 1 && !reduce) {
                setTimeout(() => {
                    this.timer = setInterval(() => (this.i = (this.i + 1) % this.n), opts.interval ?? 4500);
                }, opts.delay ?? 0);
            }
        },

        layout() {
            // quads are relative to the photo box: x-ref="host" when the component spans more than the photo
            const host = this.$refs.host || this.$el;
            const W = host.clientWidth;
            const H = host.clientHeight;
            if (!W || !H) return;
            host.querySelectorAll('.vw-screen').forEach((el) => {
                if (el.dataset.quad) {
                    const aspect = parseFloat(el.dataset.aspect || 16 / 9);
                    const h = BASE / aspect;
                    const quad = parsePoints(el.dataset.quad).map(([x, y]) => [(x / 100) * W, (y / 100) * H]);
                    el.style.width = `${BASE}px`;
                    el.style.height = `${h}px`;
                    el.style.transform = homography(BASE, h, quad);
                } else if (el.dataset.box) {
                    const [x0, y0, x1, y1] = el.dataset.box.split(',').map(Number);
                    Object.assign(el.style, { left: `${x0}%`, top: `${y0}%`, width: `${x1 - x0}%`, height: `${y1 - y0}%` });
                }
            });
        },

        destroy() {
            clearInterval(this.timer);
            this.ro?.disconnect();
            window.removeEventListener('resize', this.onResize);
        },
    }));

    Alpine.data('pixelDissolve', (images = [], cols = 16, rows = 9, interval = 4200) => ({
        current: 0,
        next: 1,
        tiles: [],
        fading: false,

        init() {
            this.tiles = Array.from({ length: cols * rows }, (_, k) => ({
                k,
                x: cols > 1 ? ((k % cols) / (cols - 1)) * 100 : 0,
                y: rows > 1 ? (Math.floor(k / cols) / (rows - 1)) * 100 : 0,
                delay: 0,
            }));
            if (images.length < 2 || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            this.timer = setInterval(() => this.advance(), interval);
        },

        advance() {
            this.next = (this.current + 1) % images.length;
            this.tiles.forEach((t) => (t.delay = Math.round(Math.random() * 900)));
            this.fading = true;
            setTimeout(() => {
                this.current = this.next;
                this.fading = false;
            }, 1500);
        },

        tileStyle(t) {
            return `background-image: url('${images[this.next]}'); background-size: ${cols * 100}% ${rows * 100}%; `
                + `background-position: ${t.x}% ${t.y}%; transition-delay: ${this.fading ? t.delay : 0}ms`;
        },

        destroy() {
            clearInterval(this.timer);
        },
    }));

    Alpine.data('wallBuilder', (panels = [], contents = [], whatsapp = '', bezels = [], start = null) => ({
        panels,
        contents,
        bezels,
        p: start ?? panels.length - 1,
        bi: 0,
        cols: 3,
        rows: 3,
        c: 0,
        mode: 'span',
        build: 0,
        width: 0,

        init() {
            this.measure();
            this.ro = new ResizeObserver(() => this.measure());
            this.ro.observe(this.$refs.stage);
            this.$watch('p', () => this.build++);
            this.$watch('bi', () => this.build++);
            this.$watch('cols', () => this.build++);
            this.$watch('rows', () => this.build++);
        },

        measure() {
            this.width = this.$refs.stage?.clientWidth ?? 0;
        },

        get panel() { return this.panels[this.p]; },
        // bezel-to-bezel gap: chosen separately when the page offers bezel options
        get bezel() { return this.bezels.length ? this.bezels[this.bi] : this.panel.bezel; },
        get count() { return this.cols * this.rows; },
        // total size including the bezel seams between panels (mm)
        get wMm() { return this.cols * this.panel.w + (this.cols - 1) * this.bezel; },
        get hMm() { return this.rows * this.panel.h + (this.rows - 1) * this.bezel; },
        get diagonal() { return Math.round(Math.hypot(this.wMm, this.hMm) / 25.4); },
        get resolution() { return `${(this.cols * 1920).toLocaleString()} × ${(this.rows * 1080).toLocaleString()}`; },
        get area() { return ((this.wMm * this.hMm) / 1e6).toFixed(2); },

        // stage fits inside the available box, keeping the wall's real proportions
        get stageStyle() {
            const maxW = this.width || 800;
            const maxH = Math.min(520, maxW * 0.62);
            const s = Math.min(maxW / this.wMm, maxH / this.hMm);
            return `width: ${this.wMm * s}px; height: ${this.hMm * s}px; --seam: ${Math.max(1, this.bezel * s * 2)}px`;
        },

        tileStyle(k) {
            const col = k % this.cols;
            const row = Math.floor(k / this.cols);
            if (this.mode === 'span') {
                const x = this.cols > 1 ? (col / (this.cols - 1)) * 100 : 50;
                const y = this.rows > 1 ? (row / (this.rows - 1)) * 100 : 50;
                return `background-image: url('${this.contents[this.c].img}'); background-size: ${this.cols * 100}% ${this.rows * 100}%; `
                    + `background-position: ${x}% ${y}%; animation-delay: ${(col + row) * 70}ms`;
            }
            const img = this.contents[(this.c + k) % this.contents.length].img;
            return `background-image: url('${img}'); background-size: cover; background-position: center; animation-delay: ${(col + row) * 70}ms`;
        },

        step(axis, d) {
            this[axis] = Math.min(6, Math.max(1, this[axis] + d));
        },

        get enquiry() {
            const text = `Hi Yara, I would like a quote for an LCD video wall: ${this.cols} × ${this.rows} of ${this.panel.name} panels with a ${this.bezel} mm bezel `
                + `(${this.count} panels, about ${(this.wMm / 1000).toFixed(2)} m × ${(this.hMm / 1000).toFixed(2)} m).`;
            return `https://wa.me/${whatsapp}?text=${encodeURIComponent(text)}`;
        },

        destroy() {
            this.ro?.disconnect();
        },
    }));
});
