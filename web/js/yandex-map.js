const yandexMap = document.querySelector('#map');

// ymaps.ready(init);

// function init() {
//     var myMap = new ymaps.Map("map", {
//             center: [55.76, 37.64],
//             zoom: 10
//         }, {
//             searchControlProvider: 'yandex#search'
//         }),

//     // Создаем геообъект с типом геометрии "Точка".
//         myGeoObject = new ymaps.GeoObject({
//             // Описание геометрии.
//             geometry: {
//                 type: "Point",
//                 coordinates: [55.8, 37.8]
//             },
//             // Свойства.
//             properties: {
//                 // Контент метки.
//                 iconContent: 'Я тащусь',
//                 hintContent: 'Ну давай уже тащи'
//             }
//         }, {
//             // Опции.
//             // Иконка метки будет растягиваться под размер ее содержимого.
//             preset: 'islands#blackStretchyIcon',
//             // Метку можно перемещать.
//             draggable: true
//         }),
//         myPieChart = new ymaps.Placemark([
//             55.847, 37.6
//         ], {
//             // Данные для построения диаграммы.
//             data: [
//                 {weight: 8, color: '#0E4779'},
//                 {weight: 6, color: '#1E98FF'},
//                 {weight: 4, color: '#82CDFF'}
//             ],
//             iconCaption: "Диаграмма"
//         }, {
//             // Зададим произвольный макет метки.
//             iconLayout: 'default#pieChart',
//             // Радиус диаграммы в пикселях.
//             iconPieChartRadius: 30,
//             // Радиус центральной части макета.
//             iconPieChartCoreRadius: 10,
//             // Стиль заливки центральной части.
//             iconPieChartCoreFillStyle: '#ffffff',
//             // Cтиль линий-разделителей секторов и внешней обводки диаграммы.
//             iconPieChartStrokeStyle: '#ffffff',
//             // Ширина линий-разделителей секторов и внешней обводки диаграммы.
//             iconPieChartStrokeWidth: 3,
//             // Максимальная ширина подписи метки.
//             iconPieChartCaptionMaxWidth: 200
//         });
    
//         $.ajax({
//             url: 'http://localhost/wimc/web/ajax',
//             method: 'get',
//             dataType: 'json',
//             success: function(data){
//                 console.log(data);
//                 // alert(data.text);    /* выведет "Текст" */
//                 // alert(data.error);   /* выведет "Ошибка" */

//                 // data.forEach((item) => {
//                 //     ymaps.geoQuery(ymaps.geocode(item)).addToMap(myMap);
//                 // });

//                 for (var i = 0, l = data.length; i < l; i++) {
//                     blueCollection.add(new ymaps.Placemark(data[i]));
//                 }
            
//                 myMap.geoObjects.add(blueCollection);

//                 // myMap.geoObjects
//                 // .add(myGeoObject)
//                 // .add(myPieChart)
//                 // .add(new ymaps.Placemark(data[0], {
//                 //     balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
//                 // }, {
//                 //     preset: 'islands#icon',
//                 //     iconColor: '#0095b6'
//                 // }));
//             }
//         });

 
// }


ymaps.ready(init);

function init() {
    var myMap = new ymaps.Map("map", {
            center: [55.73, 77.75],
            zoom: 3,
            controls: []
        }, {
            searchControlProvider: 'yandex#search'
        }),
        yellowCollection = new ymaps.GeoObjectCollection(null, {
            preset: 'islands#yellowIcon'
        }),
        blueCollection = new ymaps.GeoObjectCollection(null, {
            preset: 'islands#blueIcon'
        });
        // yellowCoords = [[55.73, 37.75], [55.81, 37.75]],
        // blueCoords = [[55.73, 37.65], [55.81, 37.65]];

    // for (var i = 0, l = yellowCoords.length; i < l; i++) {
    //     yellowCollection.add(new ymaps.Placemark(yellowCoords[i]));
    // }
    // for (var i = 0, l = blueCoords.length; i < l; i++) {
    //     blueCollection.add(new ymaps.Placemark(blueCoords[i]));
    // }

    // myMap.geoObjects.add(blueCollection);

    // // Через коллекции можно подписываться на события дочерних элементов.
    // yellowCollection.events.add('click', function () { alert('Кликнули по желтой метке') });
    // blueCollection.events.add('click', function () { alert('Кликнули по синей метке') });

    // // Через коллекции можно задавать опции дочерним элементам.
    // blueCollection.options.set('preset', 'islands#blueDotIcon');


            $.ajax({
            url: 'http://localhost/wimc/web/ajax',
            method: 'get',
            dataType: 'json',
            success: function(data){
                console.log(data);
                // alert(data.text);    /* выведет "Текст" */
                // alert(data.error);   /* выведет "Ошибка" */

                // data.forEach((item) => {
                //     ymaps.geoQuery(ymaps.geocode(item)).addToMap(myMap);
                // });

                for (var i = 0, l = data.length; i < l; i++) {
                    yellowCollection.add(new ymaps.Placemark(data[i]));
                }
            
                myMap.geoObjects.add(yellowCollection);

                // myMap.geoObjects
                // .add(myGeoObject)
                // .add(myPieChart)
                // .add(new ymaps.Placemark(data[0], {
                //     balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
                // }, {
                //     preset: 'islands#icon',
                //     iconColor: '#0095b6'
                // }));
            }
        });
}