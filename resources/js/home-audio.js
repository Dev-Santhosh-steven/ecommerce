/**
 * Home Audio explore page: a small synthesised demo beat (Web Audio API, no audio files)
 * that drives the equaliser bars and the --bass pulse on the speakers.
 *
 * Usage: <section x-data="yaraBeat"> … <div class="ha-eq" x-ref="eq"><span>…</span></div>
 * Sound only starts when the visitor presses Play.
 */

const BPM = 96;
const STEP = 60 / BPM / 4; // 16th notes
const KICK = [0, 6, 8, 11];
const SNARE = [4, 12];
const BASS_ROOTS = [55, 43.65, 65.41, 49]; // A1, F1, C2, G1 — one per bar

function noiseBuffer(ctx) {
    const buffer = ctx.createBuffer(1, ctx.sampleRate, ctx.sampleRate);
    const data = buffer.getChannelData(0);
    for (let i = 0; i < data.length; i++) data[i] = Math.random() * 2 - 1;
    return buffer;
}

function kick(ctx, out, t) {
    const osc = ctx.createOscillator();
    const gain = ctx.createGain();
    osc.frequency.setValueAtTime(150, t);
    osc.frequency.exponentialRampToValueAtTime(42, t + 0.12);
    gain.gain.setValueAtTime(1, t);
    gain.gain.exponentialRampToValueAtTime(0.001, t + 0.45);
    osc.connect(gain).connect(out);
    osc.start(t);
    osc.stop(t + 0.5);
}

function noiseHit(ctx, out, noise, t, { freq, level, decay }) {
    const src = ctx.createBufferSource();
    const filter = ctx.createBiquadFilter();
    const gain = ctx.createGain();
    src.buffer = noise;
    filter.type = 'highpass';
    filter.frequency.value = freq;
    gain.gain.setValueAtTime(level, t);
    gain.gain.exponentialRampToValueAtTime(0.001, t + decay);
    src.connect(filter).connect(gain).connect(out);
    src.start(t);
    src.stop(t + decay + 0.05);
}

function bass(ctx, out, t, freq) {
    const osc = ctx.createOscillator();
    const filter = ctx.createBiquadFilter();
    const gain = ctx.createGain();
    osc.type = 'sawtooth';
    osc.frequency.value = freq;
    filter.type = 'lowpass';
    filter.frequency.value = 380;
    gain.gain.setValueAtTime(0.0001, t);
    gain.gain.exponentialRampToValueAtTime(0.22, t + 0.02);
    gain.gain.exponentialRampToValueAtTime(0.001, t + 0.34);
    osc.connect(filter).connect(gain).connect(out);
    osc.start(t);
    osc.stop(t + 0.4);
}

function pad(ctx, out, t, root) {
    // soft chord to give the beat some warmth
    [2, 3, 4.5].forEach((mult) => {
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        osc.type = 'triangle';
        osc.frequency.value = root * mult * 2;
        gain.gain.setValueAtTime(0.0001, t);
        gain.gain.linearRampToValueAtTime(0.025, t + 0.3);
        gain.gain.linearRampToValueAtTime(0.0001, t + STEP * 16);
        osc.connect(gain).connect(out);
        osc.start(t);
        osc.stop(t + STEP * 16 + 0.05);
    });
}

document.addEventListener('alpine:init', () => {
    window.Alpine.data('yaraBeat', () => ({
        playing: false,
        ctx: null,
        timer: null,
        frame: null,

        toggle() {
            this.playing ? this.stop() : this.play();
        },

        play() {
            const AudioCtx = window.AudioContext || window.webkitAudioContext;
            if (!AudioCtx) return;

            this.ctx = new AudioCtx();
            const ctx = this.ctx;
            this.master = ctx.createGain();
            this.master.gain.value = 0.55;
            this.analyser = ctx.createAnalyser();
            this.analyser.fftSize = 128;
            this.analyser.smoothingTimeConstant = 0.72;
            this.master.connect(this.analyser).connect(ctx.destination);
            this.noise = noiseBuffer(ctx);
            this.data = new Uint8Array(this.analyser.frequencyBinCount);

            this.step = 0;
            this.nextTime = ctx.currentTime + 0.08;
            this.timer = setInterval(() => this.schedule(), 25);
            this.playing = true;
            this.$root.classList.add('ha-playing');
            this.$refs.eq?.classList.remove('is-idle');
            this.draw();
        },

        schedule() {
            const ctx = this.ctx;
            while (this.nextTime < ctx.currentTime + 0.12) {
                const s = this.step % 16;
                const bar = Math.floor(this.step / 16) % 4;
                const t = this.nextTime;
                if (s === 0) pad(ctx, this.master, t, BASS_ROOTS[bar]);
                if (KICK.includes(s)) {
                    kick(ctx, this.master, t);
                    bass(ctx, this.master, t, BASS_ROOTS[bar]);
                }
                if (SNARE.includes(s)) noiseHit(ctx, this.master, this.noise, t, { freq: 1400, level: 0.45, decay: 0.18 });
                if (s % 2 === 1) noiseHit(ctx, this.master, this.noise, t, { freq: 7500, level: s % 4 === 3 ? 0.12 : 0.07, decay: 0.05 });
                this.nextTime += STEP;
                this.step++;
            }
        },

        draw() {
            if (!this.playing) return;
            this.analyser.getByteFrequencyData(this.data);
            const bars = this.$refs.eq ? this.$refs.eq.children : [];
            const n = bars.length;
            for (let i = 0; i < n; i++) {
                // spread bars over the lower ~70% of the spectrum, where the music lives
                const v = this.data[Math.floor((i / n) * this.data.length * 0.7)] / 255;
                bars[i].style.setProperty('--h', `${Math.max(6, v * 100)}%`);
            }
            const low = (this.data[1] + this.data[2] + this.data[3]) / (3 * 255);
            this.$root.style.setProperty('--bass', Math.max(0, (low - 0.45) / 0.55).toFixed(3));
            this.frame = requestAnimationFrame(() => this.draw());
        },

        stop() {
            this.playing = false;
            clearInterval(this.timer);
            cancelAnimationFrame(this.frame);
            this.ctx?.close();
            this.ctx = null;
            this.$root.classList.remove('ha-playing');
            this.$root.style.setProperty('--bass', 0);
            this.$refs.eq?.classList.add('is-idle');
            [...(this.$refs.eq?.children ?? [])].forEach((b) => b.style.removeProperty('--h'));
        },

        destroy() {
            this.stop();
        },
    }));
});
