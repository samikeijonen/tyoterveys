/* global kalaData */
import { Navigation, animate } from '@meom/navigation';

const siteNav = () => {
    // Mandatory elements.
    const navItems = document.querySelector('.js-site-nav-items');
    const navToggle = document.querySelector('.js-site-nav-toggle');

    // Bail if there is no nav nor toggle button.
    if (!navItems || !navToggle) {
        return;
    }

    new Navigation(navItems, navToggle, {
        subToggleButtonClasses: 'site-nav__sub-toggle',
        subSubToggleButtonClasses: 'site-nav__sub-sub-toggle',
        // Set this to false because we manually add classes for animation.
        toggleNavClass: false,
        // Translatable string for sub menu text.
        // `kalaData` is located in `/includes/enqueue-assets.php`.
        expandChildNavText: kalaData.expandChildNavText,

        onOpenNav(element) {
            // Prevent scrolling on page.
            document.documentElement.classList.add('is-overflow-hidden');
            document.documentElement.classList.add('is-site-nav-opened');
            element.classList.add('is-opened');
            animate(element, 'fade-in');
        },

        onCloseNav(element) {
            // Allow scrolling on page.
            document.documentElement.classList.remove('is-overflow-hidden');
            document.documentElement.classList.remove('is-site-nav-opened');
            animate(element, 'fade-out', 'is-opened');
        },
    });
};

export default siteNav;
