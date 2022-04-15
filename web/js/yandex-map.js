const yandexMap = document.querySelector('#map');

// if (yandexMap) {
//     ymaps.ready(init);
//     function init(){
//         var myMap = new ymaps.Map("map", {
//             center: [yandexMap.dataset.latitude, yandexMap.dataset.longitude],
//             zoom: 7
//         });
//     }
// }

ymaps.ready(init);

function init() {
    // var myMap = new ymaps.Map('map', {
    //         center: [55.753994, 37.622093],
    //         zoom: 9
    //     }, {
    //         searchControlProvider: 'yandex#search'
    //     });

        var myMap = new ymaps.Map('map', {
        center: [yandexMap.dataset.latitude, yandexMap.dataset.longitude],
        zoom: 9,
        controls: []
    });

    
    // Поиск станций метро.
    ymaps.geocode(myMap.getCenter(), {
        /**
         * Опции запроса
         * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/geocode.xml
         */
        // Ищем только станции метро.
        // kind: 'metro',
        // Запрашиваем не более 20 результатов.
        // results: 20
    }).then(function (res) {

            // // Задаем изображение для иконок меток.
            // res.geoObjects.options.set('preset', 'islands#redCircleIcon');
            // res.geoObjects.events
            //     // При наведении на метку показываем хинт с названием станции метро.
            //     .add('mouseenter', function (event) {
            //         var geoObject = event.get('target');
            //         myMap.hint.open(geoObject.geometry.getCoordinates(), geoObject.getPremise());
            //     })
            //     // Скрываем хинт при выходе курсора за пределы метки.
            //     .add('mouseleave', function (event) {
            //         myMap.hint.close(true);
            //     });
            // // Добавляем коллекцию найденных геообъектов на карту.
            // myMap.geoObjects.add(res.geoObjects);
            // // Масштабируем карту на область видимости коллекции.
            // myMap.setBounds(res.geoObjects.getBounds());
        });
}






// ymaps.ready(init);

// function init() {

//     var myMap = new ymaps.Map('map', {
//         center: [yandexMap.dataset.latitude, yandexMap.dataset.longitude],
//         zoom: 9,
//         controls: []
//     });

//     // Поиск координат центра Нижнего Новгорода.
//     ymaps.geocode('Нижний Новгород', {
//         /**
//          * Опции запроса
//          * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/geocode.xml
//          */
//         // Сортировка результатов от центра окна карты.
//         // boundedBy: myMap.getBounds(),
//         // strictBounds: true,
//         // Вместе с опцией boundedBy будет искать строго внутри области, указанной в boundedBy.
//         // Если нужен только один результат, экономим трафик пользователей.
//         results: 1
//     }).then(function (res) {
//             // Выбираем первый результат геокодирования.
//             var firstGeoObject = res.geoObjects.get(0),
//                 // Координаты геообъекта.
//                 coords = firstGeoObject.geometry.getCoordinates(),
//                 // Область видимости геообъекта.
//                 bounds = firstGeoObject.properties.get('boundedBy');

//             firstGeoObject.options.set('preset', 'islands#darkBlueDotIconWithCaption');
//             // Получаем строку с адресом и выводим в иконке геообъекта.
//             firstGeoObject.properties.set('iconCaption', firstGeoObject.getAddressLine());

//             // Добавляем первый найденный геообъект на карту.
//             myMap.geoObjects.add(firstGeoObject);
//             // Масштабируем карту на область видимости геообъекта.
//             myMap.setBounds(bounds, {
//                 // Проверяем наличие тайлов на данном масштабе.
//                 checkZoomRange: true
//             });

   

//             /**
//              * Если нужно добавить по найденным геокодером координатам метку со своими стилями и контентом балуна, создаем новую метку по координатам найденной и добавляем ее на карту вместо найденной.
//              */
//             /**
//              var myPlacemark = new ymaps.Placemark(coords, {
//              iconContent: 'моя метка',
//              balloonContent: 'Содержимое балуна <strong>моей метки</strong>'
//              }, {
//              preset: 'islands#violetStretchyIcon'
//              });

//              myMap.geoObjects.add(myPlacemark);
//              */
//         });
// }