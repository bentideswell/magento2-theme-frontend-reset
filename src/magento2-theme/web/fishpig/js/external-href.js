define([], function() {
    //
    return function (config, element) {
        var a = document.createElement('a');
        a.href = config.url;
        a.target = '_blank';
        a.innerHTML = element.innerHTML;
        element.parentNode.insertBefore(a, element);
        element.remove();
    }
});