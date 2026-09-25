import Alpine from 'alpinejs';
import Swiper from 'swiper';
import { Autoplay, Navigation, Pagination } from 'swiper/modules';
import { createIcons, icons } from 'lucide';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

Swiper.use([Autoplay, Navigation, Pagination]);

window.Alpine = Alpine;
window.Swiper = Swiper;

Alpine.start();

createIcons({ icons });

const revealObserver = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-revealed');
                revealObserver.unobserve(entry.target);
            }
        });
    },
    { threshold: 0.15, rootMargin: '0px 0px -80px 0px' },
);

document.querySelectorAll('[data-reveal]').forEach((el) => revealObserver.observe(el));

/**
 * Minimal CSV line parser (handles quoted fields containing commas).
 * Used by the admin product form to bulk-import specification/feature rows.
 */
window.parseCsvLine = function (line) {
    const result = [];
    let current = '';
    let inQuotes = false;

    for (let i = 0; i < line.length; i++) {
        const char = line[i];

        if (char === '"') {
            if (inQuotes && line[i + 1] === '"') {
                current += '"';
                i++;
            } else {
                inQuotes = !inQuotes;
            }
        } else if (char === ',' && !inQuotes) {
            result.push(current.trim());
            current = '';
        } else {
            current += char;
        }
    }

    result.push(current.trim());

    return result;
};

/**
 * Reads a CSV file and returns its non-empty rows as arrays of trimmed cells.
 */
window.readCsvFile = function (file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const lines = e.target.result
                .split(/\r?\n/)
                .filter((line) => line.trim() !== '');
            resolve(lines.map((line) => window.parseCsvLine(line)));
        };
        reader.onerror = reject;
        reader.readAsText(file);
    });
};