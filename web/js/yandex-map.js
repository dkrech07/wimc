const yandexMap = document.querySelector('#map');

if(!yandexMap.dataset.latitude && !yandexMap.dataset.longitude) {
    yandexMap.dataset.latitude = 55.76;
    yandexMap.dataset.longitude = 37.64;
}

ymaps.ready(init);

function init () {
    var myMap = new ymaps.Map('map', {
            // center: [55.76, 37.64],
        
            center: [yandexMap.dataset.latitude, yandexMap.dataset.longitude],
            zoom: 10,
            controls: []
        }, {
            searchControlProvider: 'yandex#search'
        }),
        objectManager = new ymaps.ObjectManager({
            // Чтобы метки начали кластеризоваться, выставляем опцию.
            clusterize: true,
            // ObjectManager принимает те же опции, что и кластеризатор.
            gridSize: 32,
            clusterDisableClickZoom: true
        });

    // Чтобы задать опции одиночным объектам и кластерам,
    // обратимся к дочерним коллекциям ObjectManager.
    objectManager.objects.options.set('preset', 'islands#greenDotIcon');
    objectManager.clusters.options.set('preset', 'islands#greenClusterIcons');
    myMap.geoObjects.add(objectManager);

    // myMap.geoObjects.add(new ymaps.Placemark(yandexMap.dataset.latitude, yandexMap.dataset.longitude, {
    //                 balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
    //             }, {
    //                 preset: 'islands#icon',
    //                 iconColor: '#0095b6'
    //             }));

    $.ajax({
        url: "/ajax"
    }).done(function(data) {
        objectManager.add(data);
    });

}