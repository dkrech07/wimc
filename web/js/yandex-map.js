const yandexMap = document.querySelector('#map');

function getCollectionCoords(customsCoords, collection) {
    customsCoords.forEach(custom => {
        collection.add(new ymaps.Placemark([custom['coordinates']['lat'], custom['coordinates']['lon']], {
        }));
    });
}

if(!yandexMap.dataset.latitude && !yandexMap.dataset.longitude) {
    yandexMap.dataset.latitude = 57.76;
    yandexMap.dataset.longitude = 77.64;
}

ymaps.ready(init);

function init () {
    var myMap = new ymaps.Map('map', {
        center: [yandexMap.dataset.latitude, yandexMap.dataset.longitude],
        zoom: 4,
        controls: []
    }, {
        searchControlProvider: 'yandex#search'
    }),
        mainCollection = new ymaps.GeoObjectCollection(null, { // Коллекция Основных таможенных постов;
            preset: 'islands#greenStretchyIcon',
            // iconColor: 'green'
        }),
        headCollection = new ymaps.GeoObjectCollection(null, { // Коллекция Головных таможенных постов;
            preset: 'islands#redStretchyIcon',
            // iconColor: 'red'
        }),
        exciseCollection = new ymaps.GeoObjectCollection(null, { // Коллекция Акцизных таможенных постов;
            preset: 'islands#yellowStretchyIcon',
            // iconColor: 'yellow'
        }),
        othersCollection = new ymaps.GeoObjectCollection(null, { // Коллекция Прочих таможенных постов;
            preset: 'islands#blueStretchyIcon',
            // iconColor: 'blue'
        }),
        searchCollection = new ymaps.GeoObjectCollection(null, { // Коллекция для найденных точек (одна пользовательская, вторая ближайшая);
            preset: 'islands#yellowIcon'
        });
    
    var data = {};
    // Проверяю есть ли в коллекции основных постов точки;
    if (mainCollection.getLength() === 0) {
        data['main'] = 1;
        // Отрисовываю основные таможенные посты;
        $.ajax({
            url: '/checkbox', // '/checkbox' 'http://localhost/wimc/web/checkbox'
            type: 'POST',
            data: data,
            success: function (response) {
                let customsCoords = JSON.parse(response);
                getCollectionCoords(customsCoords['main'], mainCollection);
                myMap.geoObjects.add(mainCollection);
                console.log(response);
                console.log(data);
                console.log(mainCollection.getLength());
            }
        });
    }
}

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
        //         mainCollection.add(new ymaps.Placemark([custom['coordinates']['lat'], custom['coordinates']['lon']], {
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

        // // headCollection.add(response);
  

    // Через коллекции можно задавать опции дочерним элементам.
    // mainCollection.options.set('preset', 'islands#governmentCircleIcon');

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
    //                    //     getCollectionCoords(customsCoords['main'], mainCollection);
    //                    //     myMap.geoObjects.add(mainCollection);
    //                    // } else {
    //                    //     myMap.geoObjects.removeAll(mainCollection);
    //                    // }
               
    //                    if (customsCoords['head'].length > 0) {
    //                        getCollectionCoords(customsCoords['head'], headCollection);
    //                        myMap.geoObjects.add(headCollection);
    //                    } else if(data['head'] == 0) {
    //                        myMap.geoObjects.remove(headCollection);
    //                    }

    //                    if (customsCoords['excise'].length > 0) {
    //                        getCollectionCoords(customsCoords['excise'], exciseCollection);
    //                        myMap.geoObjects.add(exciseCollection);
    //                    } else if(data['excise'] == 0) {
    //                        myMap.geoObjects.remove(exciseCollection);
    //                    }

    //                    if (customsCoords['others'].length > 0) {
    //                        getCollectionCoords(customsCoords['others'], othersCollection);
    //                        myMap.geoObjects.add(othersCollection);
    //                    } else if(data['others'] == 0) {
    //                        myMap.geoObjects.remove(othersCollection);
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