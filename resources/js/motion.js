/**
 * Site-wide motion: scroll reveals (with automatic stagger for card grids),
 * header scroll state, reading progress and back-to-top.
 *
 * Reveals can be added by hand with data-reveal (="", "left", "right", "zoom", "fade")
 * and style="--reveal-delay: 120ms". On store pages, card grids and section headings
 * below the fold are animated automatically; opt out with data-no-auto-reveal.
 */

const STAGGER_MS = 90;
const MAX_STAGGER_STEPS = 4;

function isStorePage() {
    return document.body.classList.contains('brand-page');
}

function belowFold(el) {
    return el.getBoundingClientRect().top > window.innerHeight * 0.92;
}

function skip(el) {
    return el.closest('[data-no-auto-reveal], .hero-swiper, .site-header, .yara-chatbot, [x-cloak]') !== null;
}

/**
 * Give card grids a staggered entrance and section headings a gentle rise,
 * only for content that starts below the fold (so nothing visible flickers on load).
 */
function autoReveal() {
    document.querySelectorAll('main .grid').forEach((grid) => {
        if (skip(grid) || grid.children.length < 2) return;

        // Stacked slideshows (images layered in one cell, Alpine fades them) are not card grids:
        // the reveal's opacity would show every slide at once.
        if (grid.querySelector(':scope > .col-start-1.row-start-1')) return;

        Array.from(grid.children).forEach((child, index) => {
            if (child.hasAttribute('data-reveal') || child.querySelector('[data-reveal]') || !belowFold(child)) return;

            child.setAttribute('data-reveal', '');
            child.style.setProperty('--reveal-delay', `${(index % MAX_STAGGER_STEPS) * STAGGER_MS}ms`);
        });
    });

    document.querySelectorAll('main h2').forEach((heading) => {
        if (skip(heading) || heading.closest('[data-reveal]') || !belowFold(heading)) return;

        // Reveal the whole heading block (eyebrow + title + intro) when it's a small wrapper.
        const block = heading.parentElement && heading.parentElement.childElementCount <= 4 && heading.parentElement.tagName !== 'SECTION'
            ? heading.parentElement
            : heading;

        if (!block.hasAttribute('data-reveal') && !block.closest('[data-reveal]')) {
            block.setAttribute('data-reveal', '');
        }
    });
}

export function initMotion() {
    if (isStorePage()) {
        autoReveal();
    }

    const revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    revealObserver.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -60px 0px' },
    );

    document.querySelectorAll('[data-reveal]').forEach((el) => revealObserver.observe(el));

    const header = document.querySelector('.site-header');
    const progress = document.querySelector('.scroll-progress');
    const backToTop = document.querySelector('.back-to-top');
    const ring = backToTop?.querySelector('.ring');
    const ringLength = ring ? ring.getTotalLength() : 0;

    if (ring) {
        ring.style.strokeDasharray = ringLength;
        ring.style.strokeDashoffset = ringLength;
    }

    let ticking = false;

    const update = () => {
        ticking = false;

        const y = window.scrollY;
        const max = Math.max(1, document.documentElement.scrollHeight - window.innerHeight);
        const ratio = Math.min(1, y / max);

        header?.classList.toggle('is-scrolled', y > 24);

        if (progress) progress.style.transform = `scaleX(${ratio})`;

        if (backToTop) {
            backToTop.classList.toggle('is-visible', y > 600);
            if (ring) ring.style.strokeDashoffset = ringLength * (1 - ratio);
        }

        // Safety net: a fast flick or anchor jump can skip past an element between
        // observer checks, so reveal anything on screen or already scrolled past.
        document.querySelectorAll('[data-reveal]:not(.is-revealed)').forEach((el) => {
            if (el.getBoundingClientRect().top < window.innerHeight - 40) {
                el.classList.add('is-revealed');
                revealObserver.unobserve(el);
            }
        });
    };

    window.addEventListener(
        'scroll',
        () => {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(update);
        },
        { passive: true },
    );

    // Throttled fallback when the tab isn't painting frames (rAF paused).
    window.addEventListener('scroll', () => setTimeout(() => ticking && update(), 200), { passive: true });

    backToTop?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    update();
}
