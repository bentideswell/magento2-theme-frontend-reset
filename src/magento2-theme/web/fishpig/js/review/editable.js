//
//
//
define([], function() {
    //
    return function (config, element) {
        function getIdFromValue(value) {
            return Math.ceil(value);
        }
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ratings[' + config.ratingId + ']';
        input.value = getIdFromValue(element.getAttribute('data-percent') / 20);
        element.appendChild(input);
        element.addEventListener('click', function (event) {
            var el = event.currentTarget;
            var value = Math.ceil(Math.ceil((event.clientX - el.getBoundingClientRect().left) / (el.clientWidth / 100)) / 20);
            el.setAttribute('data-percent', value * 20);
            input.value = getIdFromValue(value);
        });
    };
});