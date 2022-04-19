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
        zoom: 1,
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

        $.ajax({
            url: '/ajax',
            method: 'get',
            dataType: 'json',
            success: function(data){
                console.log(data);
                // alert(data.text);    /* выведет "Текст" */
                // alert(data.error);   /* выведет "Ошибка" */

                data.foreach((item) => {
                    ymaps.geoQuery(ymaps.geocode(item)).addToMap(myMap);
                });
            }
        });


       
}