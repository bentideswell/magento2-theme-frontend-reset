//
//
//
define([], function () {
    function forEach(nodes, callback) {
        if (nodes && nodes.length > 0) {
            [].forEach.call(nodes, callback);
        }
    };

    //
    return function (config, wrapper) {
        config.tabTitleSelector = config.tabTitleSelector || '.tab-title';
        config.tabContentSelector = config.tabContentSelector || '.tab-content';
        config.activeClassName = config.activeClassName || '-active';
        config.breakpoint = config.breakpoint || 768;
        config.waitingClassName = config.waitingClassName ?? '-waiting';

        function isAccordion() {
            return window.innerWidth < config.breakpoint;
        }

        function onTabTitleClick(event) {
            event.preventDefault();
            return openTabById(
                event.currentTarget.getAttribute('data-tab-id'),
                false
            );
        }

        function openTabById(tabId, scrollTo) {
            // Check tab exists in wrapper
            var requestedTabTitle = wrapper.querySelector(
                config.tabTitleSelector + '[data-tab-id="' + tabId + '"]'
            );
            if (!requestedTabTitle) {
                return;
            }

            if (activeTabId === tabId && !isAccordion()) {
                return;
            }

            // Something has been clicked, so we are no longer in a waiting state
            wrapper.classList.remove(config.waitingClassName);

            // Remove any active tab
            forEach(
                wrapper.querySelectorAll(config.tabTitleSelector + '.' + config.activeClassName),
                function (activeTabTitle) {
                    activeTabTitle.classList.remove(config.activeClassName)
                }
            );

            if (activeTabId !== tabId) {
                activeTabId = tabId;
                // Process AJAX tabs
                forEach(
                    wrapper.querySelectorAll(
                        config.tabContentSelector + '[data-tab-id="' + tabId + '"][data-tab-url]'
                    ),
                    function (contentWithUrl) {
                        var url = contentWithUrl.getAttribute('data-tab-url');
                        // This stops it being loaded twice.
                        contentWithUrl.removeAttribute('data-tab-url');
                        // Start loader
                        fpjs.loader.on();
                        // Get contents for tab
                        var ajax = new XMLHttpRequest();
                        ajax.open("GET", url, true);
                        ajax.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                        ajax.send();
                        ajax.onreadystatechange = function() {
                            if (ajax.readyState == 4/* && ajax.status == 200*/) {
                                contentWithUrl.innerHTML = ajax.responseText;

                                fpjs.run();
                                // Stop loader
                                fpjs.loader.off();
                            }
                        }
                    }
                );

                forEach(
                    wrapper.querySelectorAll(
                        config.tabTitleSelector + '[data-tab-id="' + tabId + '"]'
                    ),
                    function (clickedTabTitle) {
                        clickedTabTitle.classList.add(config.activeClassName);
                    }
                );
            } else {
                activeTabId = false;
                wrapper.classList.add(config.waitingClassName);
            }

            if (scrollTo) {
                wrapper.scrollIntoView();
            }
        };

        // Get tabTitles. Clickable links for tabs
        var tabTitles = wrapper.querySelectorAll(config.tabTitleSelector);
        tabTitles[0].classList.add('-default');

        var activeTabId = false;
        var tabTitlesWrapper = document.createElement('div');
        tabTitlesWrapper.classList.add('tab-titles-wrapper');

        [].forEach.call(tabTitles, function (tabTitle) {
            var clonedTabTitle = tabTitle.cloneNode(true);
            tabTitle.addEventListener('click', onTabTitleClick);
            clonedTabTitle.addEventListener('click', onTabTitleClick);
            tabTitlesWrapper.append(clonedTabTitle);
        });
        wrapper.insertBefore(tabTitlesWrapper, wrapper.firstElementChild);

        if (window.location.hash) {
            openTabById(window.location.hash.substring(1), true);
        }

        window.addEventListener('hashchange', function (event) {
            openTabById(window.location.hash.substring(1), true);
        });
    };
});