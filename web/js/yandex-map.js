const yandexMap = document.querySelector('#map');

if (yandexMap) {
    ymaps.ready(init);
    function init(){
        var myMap = new ymaps.Map("map", {
            center: [yandexMap.dataset.latitude, yandexMap.dataset.longitude],
            zoom: 7
        });
    }
}