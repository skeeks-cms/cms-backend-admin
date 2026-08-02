(function () {
    'use strict';

    function markReady() {
        document.documentElement.setAttribute('data-sx-auth-ready', 'true');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', markReady, {once: true});
    } else {
        markReady();
    }
}());
