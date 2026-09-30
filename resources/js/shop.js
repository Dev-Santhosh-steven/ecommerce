/**
 * Shop state shared by every page: wishlist hearts, cart count, mini cart drawer and toasts.
 *
 *  - Signed in: the wishlist lives on the server (POST /wishlist/{id}).
 *  - Signed out: hearts are kept in localStorage and merged into the account after sign-in.
 *  - The cart works for guests too (cookie) and is merged on sign-in.
 *
 * Boot data comes from window.YARA (layouts/store.blade.php).
 */
const LS_KEY = 'yara_wishlist';

const boot = window.YARA || { auth: false, wishlist: [], cartCount: 0 };

function csrf() {
    return document.querySelector('meta[name="csrf-token"]')?.content || '';
}

async function send(url, method = 'POST', body = null) {
    const res = await fetch(url, {
        method,
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf(),
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: body ? JSON.stringify(body) : null,
        credentials: 'same-origin',
    });
    const data = await res.json().catch(() => ({}));
    if (!res.ok) throw Object.assign(new Error(data.message || 'Something went wrong'), { data, status: res.status });
    return data;
}

function readLocal() {
    try {
        return JSON.parse(localStorage.getItem(LS_KEY) || '[]').map(Number).filter(Boolean);
    } catch {
        return [];
    }
}

function writeLocal(ids) {
    try {
        localStorage.setItem(LS_KEY, JSON.stringify(ids));
    } catch {
        /* storage blocked: the heart still toggles for this page view */
    }
}

document.addEventListener('alpine:init', () => {
    const Alpine = window.Alpine;

    Alpine.store('shop', {
        auth: boot.auth,
        wishlist: boot.auth ? boot.wishlist.map(Number) : readLocal(),
        cartCount: boot.cartCount,
        drawer: false,
        loading: false,
        cart: { items: [], summary: { total: 0, mrp: 0, discount: 0, count: 0 } },
        toasts: [],

        init() {
            // after sign-in: push hearts saved while signed out into the account
            const local = readLocal();
            if (this.auth && local.length) {
                send(boot.routes.wishlistMerge, 'POST', { ids: local })
                    .then((d) => { this.wishlist = d.ids.map(Number); writeLocal([]); })
                    .catch(() => {});
            }
            if (boot.toast) this.toast(boot.toast);
        },

        saved(id) {
            return this.wishlist.includes(Number(id));
        },

        async toggleWishlist(id) {
            id = Number(id);
            const was = this.saved(id);
            this.wishlist = was ? this.wishlist.filter((x) => x !== id) : [...this.wishlist, id];

            if (!this.auth) {
                writeLocal(this.wishlist);
                this.toast(was ? 'Removed from your wishlist' : 'Saved. Sign in to keep your wishlist on every device', was ? null : { label: 'Sign in', href: boot.routes.login });
                return;
            }
            try {
                const d = await send(boot.routes.wishlist.replace('__ID__', id));
                this.toast(d.message, d.saved ? { label: 'View', href: boot.routes.wishlistPage } : null);
            } catch (e) {
                this.wishlist = was ? [...this.wishlist, id] : this.wishlist.filter((x) => x !== id);
                this.toast(e.message);
            }
        },

        get wishlistCount() {
            return this.wishlist.length;
        },

        async addToCart(id, qty = 1, openDrawer = true) {
            this.loading = true;
            try {
                const d = await send(boot.routes.cartAdd.replace('__ID__', id), 'POST', { quantity: qty });
                this.apply(d);
                if (openDrawer) this.drawer = true;
                else this.toast(d.message, { label: 'View cart', href: boot.routes.cartPage });
            } catch (e) {
                this.toast(e.message);
            } finally {
                this.loading = false;
            }
        },

        async openCart() {
            this.drawer = true;
            this.icons();
            this.loading = true;
            try {
                this.apply(await send(boot.routes.cartMini, 'GET'));
            } finally {
                this.loading = false;
            }
        },

        async setQty(item, qty) {
            qty = Math.max(1, Math.min(item.max, qty));
            if (qty === item.quantity) return;
            this.apply(await send(boot.routes.cartItem.replace('__ID__', item.id), 'PATCH', { quantity: qty }));
        },

        async removeItem(item) {
            this.apply(await send(boot.routes.cartItem.replace('__ID__', item.id), 'DELETE'));
        },

        apply(d) {
            if (d.items) this.cart = { items: d.items, summary: d.summary };
            if (typeof d.count === 'number') this.cartCount = d.count;
            this.icons();
        },

        icons() {
            window.Alpine.nextTick(() => window.refreshIcons?.());
        },

        toast(message, action = null) {
            const id = Date.now() + Math.random();
            this.toasts.push({ id, message, action });
            this.icons();
            setTimeout(() => (this.toasts = this.toasts.filter((t) => t.id !== id)), 4200);
        },

        money(v) {
            return '₹' + Number(v || 0).toLocaleString('en-IN', { maximumFractionDigits: 0 });
        },
    });
});
