/**
 * Laravel Mobile Menu
 * https://github.com/yourname/laravel-mobile-menu
 *
 * Auto-initializes any [data-mm-menu] / [data-mm-toggle] / [data-mm-overlay] triples.
 * Safe to include multiple times.
 */
(function () {
    'use strict';

    function init() {
        const burger = document.querySelector('[data-mm-toggle]');
        const overlay = document.querySelector('[data-mm-overlay]');
        const menu = document.querySelector('[data-mm-menu]');

        if (!burger || !overlay || !menu) {
            return;
        }

        const open = () => {
            burger.setAttribute('aria-expanded', 'true');
            burger.setAttribute('aria-label', burger.dataset.closeLabel || 'Закрыть меню');
            menu.setAttribute('aria-hidden', 'false');
            overlay.setAttribute('aria-hidden', 'false');
            document.body.classList.add('is-mm-open');
        };

        const close = () => {
            burger.setAttribute('aria-expanded', 'false');
            burger.setAttribute('aria-label', burger.dataset.openLabel || 'Открыть меню');
            menu.setAttribute('aria-hidden', 'true');
            overlay.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('is-mm-open');
        };

        const toggle = () => {
            const isOpen = burger.getAttribute('aria-expanded') === 'true';
            isOpen ? close() : open();
        };

        burger.addEventListener('click', toggle);
        overlay.addEventListener('click', close);

        menu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', close);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && burger.getAttribute('aria-expanded') === 'true') {
                close();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();