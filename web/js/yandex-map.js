const yandexMap = document.querySelector('#map');

// function getCollectionCoords(customsCoords, points) {
//     customsCoords.forEach(custom => {
//         points.push([custom['coordinates']['lat'], custom['coordinates']['lon']]);
//     });
// }

function getCollection(myMap, customsParam, collection) {
    if (customsParam) {
        myMap.geoObjects.add(collection);
    } else {
        myMap.geoObjects.remove(collection);
    }
}

if(!yandexMap.dataset.latitude && !yandexMap.dataset.longitude) {
    yandexMap.dataset.latitude = 57.76;
    yandexMap.dataset.longitude = 77.64;
}

ymaps.ready(init);

function init () {
    var myMap = new ymaps.Map('map', {
        center: [yandexMap.dataset.latitude, yandexMap.dataset.longitude],
        zoom: 3,
        controls: []
    }, {
        searchControlProvider: 'yandex#search',
    }),
    clusterer = new ymaps.Clusterer({
        // Макет метки кластера pieChart.
        clusterIconLayout: 'default#pieChart',
        // Радиус диаграммы в пикселях.
        clusterIconPieChartRadius: 25,
        // Радиус центральной части макета.
        clusterIconPieChartCoreRadius: 10,
        // Ширина линий-разделителей секторов и внешней обводки диаграммы.
        clusterIconPieChartStrokeWidth: 3,
        // Определяет наличие поля balloon.
        hasBalloon: false
    }),
        points = {
            'main': [],
            'head': [],
            'excise': [],
            'others': [],
        },
        geoObjects = [];

        // new ymaps.GeoObjectCollection(null, { // Коллекция Основных таможенных постов;
        //     // preset: 'islands#greenStretchyIcon',
        //     iconColor: 'green'
        // }),

        
        // new ymaps.GeoObjectCollection(null, { // Коллекция Головных таможенных постов;
        //     // preset: 'islands#redStretchyIcon',
        //     iconColor: 'red'
        // }),

        
        // new ymaps.GeoObjectCollection(null, { // Коллекция Акцизных таможенных постов;
        //     // preset: 'islands#yellowStretchyIcon',
        //     iconColor: 'yellow'
        // }),
        
        
        // new ymaps.GeoObjectCollection(null, { // Коллекция Прочих таможенных постов;
        //     // preset: 'islands#blueStretchyIcon',
        //     iconColor: 'blue'
        // }),
        // searchCollection = new ymaps.GeoObjectCollection(null, { // Коллекция для найденных точек (одна пользовательская, вторая ближайшая);
        //     preset: 'islands#yellowIcon'
        // });

    // Карта коллекций
    // var customsMap = {
    //     'main': mainPoints,
    //     'head': headPoints,
    //     'excise': excisePoints,
    //     'others': othersPoints,
    // };

    // Карта состояний чекбоксов
    var data = {
        'main': 0,
        'head': 1,
        'excise': 1,
        'others': 1,
        'captions': 0,
     };

    // Отрисовываю основные таможенные посты;
        $.ajax({
            url: 'http://localhost/wimc/web/checkbox', // '/checkbox' 'http://localhost/wimc/web/checkbox'
            type: 'POST',
            data: data,
            success: function (response) {
                let customsCoords = JSON.parse(response);

                // getCollectionCoords(customsCoords['main'], points['main']);
                // getCollectionCoords(customsCoords['head'], points['head']);
                // getCollectionCoords(customsCoords['excise'], points['excise']);
                // getCollectionCoords(customsCoords['others'], points['others']);

                // console.log(mainPoints);
                // console.log(headPoints);
                // console.log(excisePoints);
                // console.log(othersPoints);

                // for (let checkbox in data) {
                //     if (data[checkbox]) {
                //         getCollectionCoords(customsCoords[checkbox], customsMap[checkbox], data['captions']);
                //         myMap.geoObjects.add(customsMap[checkbox]);
                //     }
                // } 

                function getPoints(points, color) {
                    // if (points.length > 0) {
                        for (var i = 0, len = points.length; i < len; i++) {
                            console.log(points[i]);
                            geoObjects[i] = new ymaps.Placemark([points[i]['coordinates']['lat'], points[i]['coordinates']['lon']], 
                            {
                                iconCaption: points[i]['properties']['iconCaption'],
                                balloonContentHeader: points[i]['properties']['balloonContentHeader'],
                                balloonContentBody: points[i]['properties']['balloonContentBody'],
                                balloonContentFooter: points[i]['properties']['balloonContentFooter'],
                            }, {
                                iconColor: color,
                            });
                        }
                    // }
                }


                getPoints(customsCoords['main'], 'green');
                getPoints(customsCoords['head'], 'red');
                getPoints(customsCoords['others'], 'blue');
                getPoints(customsCoords['excise'], 'yellow');


            

                clusterer.add(geoObjects);
                myMap.geoObjects.add(clusterer);

                // myMap.setBounds(clusterer.getBounds(), {
                //     checkZoomRange: true
                // });
        }
        });
 
    // Отрысовывает точки при фильтрации по типам постов;
    // let checkboxes = Array.from(document.querySelectorAll('.customs-checkbox'));
    // let captionsFlag = 0;
    // console.log(checkboxes);

    // checkboxes.forEach(function(checkbox, i) {
    //     checkbox.onchange = function() {
    //         checkboxes.forEach(function(checkbox){
    //             data[checkbox.id] = checkbox.checked ? 1:0;
    //         });

            // if (checkbox.id == 'captions') {
            //     console.log(data[checkbox.id]);
            // }

            // $.ajax({
            //     url: 'http://localhost/wimc/web/checkbox', // '/checkbox' 'http://localhost/wimc/web/checkbox'
            //     type: 'POST',
            //     data: data,
            //     success: function (response) {
            //         let customsCoords = JSON.parse(response);
            //         if (data[checkbox.id] == 1 && checkbox.id !== 'captions') {
            //             let customsCoords = JSON.parse(response);
            //             getCollectionCoords(customsCoords[checkbox.id], customsMap[checkbox.id], data['captions']);
            //             myMap.geoObjects.add(customsMap[checkbox.id]);
            //         } else if (checkbox.id == 'captions') {
            //             let customsCoords = JSON.parse(response);

            //             if (data[checkbox.id] != captionsFlag) {
            //                 // myMap.geoObjects.removeAll();
            //                 captionsFlag = data[checkbox.id];
            //             }

            //             if (mainPoints.getLength() > 0) {

            //                 getCollectionCoords(customsCoords['main'], customsMap['main'], data['captions']);
            //                 myMap.geoObjects.add(customsMap['main']);
            //             }
            //             if (headPoints.getLength() > 0) {
            //                 myMap.geoObjects.remove(customsMap['head']);

            //                 getCollectionCoords(customsCoords['head'], customsMap['head'], data['captions']);
            //                 myMap.geoObjects.add(customsMap['head']);
            //             }
            //             if (excisePoints.getLength() > 0) {
            //                 myMap.geoObjects.remove(customsMap['excise']);

            //                 getCollectionCoords(customsCoords['excise'], customsMap['excise'], data['captions']);
            //                 myMap.geoObjects.add(customsMap['excise']);
            //             }
            //             if (othersPoints.getLength() > 0) {
            //                 myMap.geoObjects.remove(customsMap['others']);

            //                 getCollectionCoords(customsCoords['others'], customsMap['others'], data['captions']);
            //                 myMap.geoObjects.add(customsMap['others']);
            //             }
                        
            //         } else {
            //             myMap.geoObjects.remove(customsMap[checkbox.id]);
            //         }

            //         // console.log(response);
            //         console.log(data['captions']);
            //         }
            // });
    //     }
    // });

    
    // mainPoints.each(callback[, context])

    myMap.geoObjects.events.add('click', function (e) {
    var code = e.get('target').properties;
    console.log(code);
    // var objectId = e.get('objectId'),
    //     obj = objectManager.objects.getById(objectId);
    // if (hasBalloonData(objectId)) {
    //     objectManager.objects.balloon.open(objectId);
    // } else {
    //     obj.properties.balloonContent = "Идет загрузка данных...";
    //     objectManager.objects.balloon.open(objectId);
    //     loadBalloonData(objectId).then(function (data) {
    //         obj.properties.balloonContent = data;
    //         objectManager.objects.balloon.setData(obj);
    //     });
    // }
});
} // конец



// $('#head').button('toggle');

// objectManager = new ymaps.ObjectManager({
//     // Чтобы метки начали кластеризоваться, выставляем опцию.
//     clusterize: true,
//     // ObjectManager принимает те же опции, что и кластеризатор.
//     minClusterSize: 8,
//     gridSize: 16,
//     clusterDisableClickZoom: true,
//     groupByCoordinates: false,
// });

// getCountsCount(response); // Получаю количество отрисованных метов в отдельной функции

// function getCountsCount (response) {
//     let costomsObj = JSON.parse(response);

//     var customsCountElement = document.querySelector('.customs-number');
//     customsCountElement.textContent = costomsObj['customs_count'];
// }

        // if (customsCoords['main'].length > 0) {
        //     customsCoords.forEach(custom => {
        //         mainPoints.add(new ymaps.Placemark([custom['coordinates']['lat'], custom['coordinates']['lon']], {
        //             // balloonContent: 'цвет <strong>носика Гены</strong>',
        //             // hintContent: 'Ну давай уже тащи',
        //             // iconContent: 'Я тащусь',
        //             // iconCaption: custom['properties']['iconCaption'],
        //             balloonContentHeader: custom['properties']['balloonContentHeader'],
        //             balloonContentBody: custom['properties']['balloonContentBody'],
        //             balloonContentFooter: custom['properties']['balloonContentFooter'],
        //         }));
        //     });
            
        // }
    

        

        // objectManager.add(response);

        // objectManager.ObjectCollection(response);

        // // headPoints.add(response);
  

    // Через коллекции можно задавать опции дочерним элементам.
    // mainPoints.options.set('preset', 'islands#governmentCircleIcon');

    //    // Отрысовывает точки при фильтрации по типам постов;
    //    let checkboxes = Array.from(document.querySelectorAll('.customs-checkbox'));
    //    var data = {};
    //    checkboxes.forEach(function(checkbox, i) {
    //        checkbox.onchange = function() {
    //            checkboxes.forEach(function(checkbox){
    //                data[checkbox.id] = checkbox.checked ? 1:0;
    //            });
   
    //            $.ajax({
    //                url: '/checkbox', // '/checkbox' 'http://localhost/wimc/web/checkbox'
    //                type: 'POST',
    //                data: data,
    //                success: function (response) {
    //                    console.log(response);

    //                    let customsCoords = JSON.parse(response);
    //                    console.log(data);
    //                    console.log(customsCoords);

    //                    // if (customsCoords['main'].length > 0) {
    //                    //     getCollectionCoords(customsCoords['main'], mainPoints);
    //                    //     myMap.geoObjects.add(mainPoints);
    //                    // } else {
    //                    //     myMap.geoObjects.removeAll(mainPoints);
    //                    // }
               
    //                    if (customsCoords['head'].length > 0) {
    //                        getCollectionCoords(customsCoords['head'], headPoints);
    //                        myMap.geoObjects.add(headPoints);
    //                    } else if(data['head'] == 0) {
    //                        myMap.geoObjects.remove(headPoints);
    //                    }

    //                    if (customsCoords['excise'].length > 0) {
    //                        getCollectionCoords(customsCoords['excise'], excisePoints);
    //                        myMap.geoObjects.add(excisePoints);
    //                    } else if(data['excise'] == 0) {
    //                        myMap.geoObjects.remove(excisePoints);
    //                    }

    //                    if (customsCoords['others'].length > 0) {
    //                        getCollectionCoords(customsCoords['others'], othersPoints);
    //                        myMap.geoObjects.add(othersPoints);
    //                    } else if(data['others'] == 0) {
    //                        myMap.geoObjects.remove(othersPoints);
    //                    }
               

    //                    // objectManager.removeAll();
    //                    // objectManager.add(response);
    //                    // getCountsCount(response)
    //                    // console.log(response);
    //                }
    //            });
    //        }
    //    });

    // Чтобы задать опции одиночным объектам и кластерам,
    // обратимся к дочерним коллекциям ObjectManager.
    // objectManager.objects.options.set('preset', 'islands#greenDotIcon');
    // objectManager.clusters.options.set('preset', 'islands#greenClusterIcons');


    // console.log(objectManager.objects._objectsById);
    // console.log(objectManager.objects._objectsById);
    // Отприсовывает точки при загрузке страницы;

// balloonContent: 'цвет <strong>носика Гены</strong>',
// hintContent: 'Ну давай уже тащи',
// iconContent: 'Я тащусь',
// iconCaption: custom['properties']['iconCaption'],

        
// balloonContentHeader: custom['properties']['balloonContentHeader'],
// balloonContentBody: custom['properties']['balloonContentBody'],
// balloonContentFooter: custom['properties']['balloonContentFooter'],

// myMap.geoObjects.add(objectManager);

// myMap.geoObjects.events.add('click', function (e) {
//     var code = e.get('target').properties;
//     console.log(code);
//     // var objectId = e.get('objectId'),
//     //     obj = objectManager.objects.getById(objectId);
//     // if (hasBalloonData(objectId)) {
//     //     objectManager.objects.balloon.open(objectId);
//     // } else {
//     //     obj.properties.balloonContent = "Идет загрузка данных...";
//     //     objectManager.objects.balloon.open(objectId);
//     //     loadBalloonData(objectId).then(function (data) {
//     //         obj.properties.balloonContent = data;
//     //         objectManager.objects.balloon.setData(obj);
//     //     });
//     // }
// });

//    // Отрисовывает точки при поиске обеъкта на карте;
//    $('#search-customs').on('beforeSubmit', function(){
//     var data = $(this).serialize();
//     $.ajax({
//     url: '/search', // 'http://localhost/wimc/web/search'
//     type: 'POST',
//     data: data,
//     success: function(res){
//         let geo = JSON.parse(res);

//         searchCollection.removeAll();
//         searchCollection.add(new ymaps.Placemark([geo['latitude'], geo['longitude']], {
//             balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
//         }, {
//             preset: 'islands#icon',
//             iconColor: 'red'
//         }));
//         searchCollection.add(new ymaps.Placemark([geo['nearest_lat'], geo['nearest_lon']]));
//         myMap.geoObjects.add(searchCollection);

//         // Отцентруем карту по точке пользователя;
//         // console.log('Новый центр карты:');
//         // console.log([geo['latitude'], geo['longitude']]);
//         myMap.setCenter([geo['latitude'], geo['longitude']]);
        
//         // Сделаем зум карты до двух точек (точки пользователя и ближайшего к ней поста);
//         myMap.setBounds(searchCollection.getBounds()); 
//         myMap.setZoom(myMap.getZoom()-2); //Чуть-чуть уменьшить зум для красоты
//     },
//     error: function(){
//     alert('Error!');
//     }
//     });
//     return false;
// });