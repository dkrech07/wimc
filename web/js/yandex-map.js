const yandexMap = document.querySelector('#map');

function getCollectionCoords(customsCoords, collection) {
    customsCoords.forEach(custom => {
        collection.add(new ymaps.Placemark([custom['coordinates']['lat'], custom['coordinates']['lon']], {
            // balloonContent: 'цвет <strong>носика Гены</strong>',
            // hintContent: 'Ну давай уже тащи',
            // iconContent: 'Я тащусь',
            // iconCaption: custom['properties']['iconCaption'],
            balloonContentHeader: custom['properties']['balloonContentHeader'],
            balloonContentBody: custom['properties']['balloonContentBody'],
            balloonContentFooter: custom['properties']['balloonContentFooter'],
        }));
    });
}

function getCountsCount (response) {
    let costomsObj = JSON.parse(response);

    var customsCountElement = document.querySelector('.customs-number');
    customsCountElement.textContent = costomsObj['customs_count'];
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
        mainCollection = new ymaps.GeoObjectCollection(null, { // Создал коллекция Головных таможенных постов;
            preset: 'islands#governmentCircleIcon',
            iconColor: 'green'
            // preset: 'islands#redCircleIcon',
            // preset: 'islands#blackStretchyIcon',
        }), 
        headCollection = new ymaps.GeoObjectCollection(null, { // Создал коллекция Головных таможенных постов;
            preset: 'islands#governmentCircleIcon',
            iconColor: 'red'
        }),
        exciseCollection = new ymaps.GeoObjectCollection(null, { // Создал коллекция Головных таможенных постов;
            preset: 'islands#governmentCircleIcon',
            iconColor: 'yellow'
        }),
        othersCollection = new ymaps.GeoObjectCollection(null, { // Создал коллекция Головных таможенных постов;
            preset: 'islands#governmentCircleIcon',
            iconColor: 'blue'
        }),
        searchCollection = new ymaps.GeoObjectCollection(null, { // Создал коллекция для найденных точек (одна пользовательская, вторая ближайшая);
            preset: 'islands#yellowIcon'
        }),
        objectManager = new ymaps.ObjectManager({
            // Чтобы метки начали кластеризоваться, выставляем опцию.
            clusterize: true,
            // ObjectManager принимает те же опции, что и кластеризатор.
            minClusterSize: 8,
            gridSize: 16,
            clusterDisableClickZoom: true,
            groupByCoordinates: false,
        });

    // Чтобы задать опции одиночным объектам и кластерам,
    // обратимся к дочерним коллекциям ObjectManager.
    // objectManager.objects.options.set('preset', 'islands#greenDotIcon');
    // objectManager.clusters.options.set('preset', 'islands#greenClusterIcons');


    // console.log(objectManager.objects._objectsById);
    // console.log(objectManager.objects._objectsById);
    // Отприсовывает точки при загрузке страницы;

    $.ajax({
        url: 'http://localhost/wimc/web/checkbox' // "/ajax" // '/checkbox' "http://localhost/wimc/web/checkbox"
    }).done(function(response) {
        console.log(response);

        // getCountsCount(response); // Получаю количество отрисованных метов в отдельной функции

        let customsCoords = JSON.parse(response);
        console.log(customsCoords);

        if (customsCoords['main'].length > 0) {
            getCollectionCoords(customsCoords['main'], mainCollection);
            myMap.geoObjects.add(mainCollection);
        }



            // Отрысовывает точки при фильтрации по типам постов;
        let checkboxes = Array.from(document.querySelectorAll('.customs-checkbox'));
        var data = {};
        checkboxes.forEach(function(checkbox, i) {
            checkbox.onchange = function() {
                checkboxes.forEach(function(checkbox){
                    data[checkbox.id] = checkbox.checked ? 1:0;
                });
    
                $.ajax({
                    url: 'http://localhost/wimc/web/checkbox', // '/checkbox' 'http://localhost/wimc/web/checkbox'
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        console.log(response);

                        let customsCoords = JSON.parse(response);
                        console.log(data);
                        console.log(customsCoords);

                        // if (customsCoords['main'].length > 0) {
                        //     getCollectionCoords(customsCoords['main'], mainCollection);
                        //     myMap.geoObjects.add(mainCollection);
                        // } else {
                        //     myMap.geoObjects.removeAll(mainCollection);
                        // }
                
                        if (customsCoords['head'].length > 0) {
                            getCollectionCoords(customsCoords['head'], headCollection);
                            myMap.geoObjects.add(headCollection);
                        } else if(data['head'] == 0) {
                            myMap.geoObjects.remove(headCollection);
                        }

                        if (customsCoords['excise'].length > 0) {
                            getCollectionCoords(customsCoords['excise'], exciseCollection);
                            myMap.geoObjects.add(exciseCollection);
                        } else if(data['excise'] == 0) {
                            myMap.geoObjects.remove(exciseCollection);
                        }

                        if (customsCoords['others'].length > 0) {
                            getCollectionCoords(customsCoords['others'], othersCollection);
                            myMap.geoObjects.add(othersCollection);
                        } else if(data['others'] == 0) {
                            myMap.geoObjects.remove(othersCollection);
                        }
                

                        // objectManager.removeAll();
                        // objectManager.add(response);
                        // getCountsCount(response)
                        // console.log(response);
                    }
                });
            }
        });
   


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
    });


    // Через коллекции можно задавать опции дочерним элементам.
    // mainCollection.options.set('preset', 'islands#governmentCircleIcon');








    // Отрисовывает точки при поиске обеъкта на карте;
    $('#search-customs').on('beforeSubmit', function(){
        var data = $(this).serialize();
        $.ajax({
        url: 'http://localhost/wimc/web/search', // 'http://localhost/wimc/web/search'
        type: 'POST',
        data: data,
        success: function(res){
            let geo = JSON.parse(res);

            searchCollection.removeAll();
            searchCollection.add(new ymaps.Placemark([geo['latitude'], geo['longitude']], {
                balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
            }, {
                preset: 'islands#icon',
                iconColor: 'red'
            }));
            searchCollection.add(new ymaps.Placemark([geo['nearest_lat'], geo['nearest_lon']]));
            myMap.geoObjects.add(searchCollection);

            // Отцентруем карту по точке пользователя;
            // console.log('Новый центр карты:');
            // console.log([geo['latitude'], geo['longitude']]);
            myMap.setCenter([geo['latitude'], geo['longitude']]);
            
            // Сделаем зум карты до двух точек (точки пользователя и ближайшего к ней поста);
            myMap.setBounds(searchCollection.getBounds()); 
            myMap.setZoom(myMap.getZoom()-2); //Чуть-чуть уменьшить зум для красоты
        },
        error: function(){
        alert('Error!');
        }
        });
        return false;
    });

    myMap.geoObjects.add(objectManager);

}