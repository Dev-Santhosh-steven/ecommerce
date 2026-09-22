import Alpine from 'alpinejs';
import Swiper from 'swiper';
import { createIcons, icons } from 'lucide';

import 'swiper/css';

window.Alpine = Alpine;
window.Swiper = Swiper;

Alpine.start();

createIcons({ icons });