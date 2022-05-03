const yandexMap = document.querySelector('#map');

if(!yandexMap.dataset.latitude && !yandexMap.dataset.longitude) {
    yandexMap.dataset.latitude = 55.76;
    yandexMap.dataset.longitude = 37.64;
}

ymaps.ready(init);

function init () {
    var myMap = new ymaps.Map('map', {    
            center: [yandexMap.dataset.latitude, yandexMap.dataset.longitude],
            zoom: 5,
            controls: []
        }, {
            searchControlProvider: 'yandex#search'
        }),
        // searchCollection = new ymaps.GeoObjectCollection(null, { // Создал коллекция для найденных точек (одна пользовательская, вторая ближайшая);
        //     preset: 'islands#yellowIcon'
        // }),
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

    $.ajax({
        url: '/checkbox' // "/ajax" // '/checkbox' "http://localhost/wimc/web/checkbox"
    }).done(function(response) {
        objectManager.add(response);
        console.log(response);
    });
   

    let checkboxes = Array.from(document.querySelectorAll('.customs-checkbox'));

    var data = {};
    checkboxes.forEach(function(checkbox, i) {
        checkbox.onchange = function() {
            checkboxes.forEach(function(checkbox){
                data[checkbox.id] = checkbox.checked ? 1:0;
            });

            $.ajax({
                url: '/checkbox', // '/checkbox' 'http://localhost/wimc/web/checkbox'
                type: 'POST',
                data: data,
                success: function (response) {
                    objectManager.removeAll();

                    objectManager.add(response);

                    console.log(response);
                }
            });
        }
    });

 

    myMap.geoObjects.add(objectManager);


}