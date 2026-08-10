(function (document) {
    'use strict';

    var widgetSelector = '.sx-dashboard-widget';
    var fullscreenClass = 'sx-dashboard-widget--fullscreen';
    var bodyFullscreenClass = 'sx-dashboard-fullscreen-active';
    var fullscreenActionSelector = '[data-sx-dashboard-action="fullscreen"]';

    function setFullscreen(widget, trigger, isFullscreen) {
        widget.classList.toggle(fullscreenClass, isFullscreen);
        trigger.setAttribute('aria-pressed', isFullscreen ? 'true' : 'false');
        document.body.classList.toggle(bodyFullscreenClass, isFullscreen);
    }

    function closeCurrentFullscreen(exceptWidget) {
        var current = document.querySelector(widgetSelector + '.' + fullscreenClass);
        if (!current || current === exceptWidget) {
            return;
        }

        var trigger = current.querySelector(fullscreenActionSelector);
        if (trigger) {
            setFullscreen(current, trigger, false);
        }
    }

    document.addEventListener('click', function (event) {
        var trigger = event.target.closest(fullscreenActionSelector);
        if (!trigger) {
            return;
        }

        var widget = trigger.closest(widgetSelector);
        if (!widget) {
            return;
        }

        event.preventDefault();
        var isFullscreen = !widget.classList.contains(fullscreenClass);
        closeCurrentFullscreen(widget);
        setFullscreen(widget, trigger, isFullscreen);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key !== 'Escape') {
            return;
        }

        var widget = document.querySelector(widgetSelector + '.' + fullscreenClass);
        if (!widget) {
            return;
        }

        var trigger = widget.querySelector(fullscreenActionSelector);
        if (trigger) {
            setFullscreen(widget, trigger, false);
            trigger.focus();
        }
    });
})(document);
