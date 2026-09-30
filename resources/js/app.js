import Alpine from 'alpinejs';
import Swiper from 'swiper';
import { Autoplay, FreeMode, Mousewheel, Navigation, Pagination, Scrollbar } from 'swiper/modules';
import { createIcons, icons } from 'lucide';
import { initMotion } from './motion';
import './home-audio';
import './video-walls';
import './shop';

import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';

Swiper.use([Autoplay, FreeMode, Mousewheel, Navigation, Pagination, Scrollbar]);

window.Alpine = Alpine;
window.Swiper = Swiper;

Alpine.start();

createIcons({ icons });

// Re-draw icons inside content Alpine renders later (mini cart, toasts).
window.refreshIcons = () => createIcons({ icons });

// Scroll reveals, header scroll state, reading progress, back-to-top.
initMotion();

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