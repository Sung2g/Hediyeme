import './bootstrap';

import Alpine from 'alpinejs';
import $ from 'jquery';

window.Alpine = Alpine;
window.$ = window.jQuery = $;

import './shop-search-nav';

Alpine.start();
