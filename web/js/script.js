// Добавляю на страницу карту;
const yandexMap = document.querySelector('#map');

// Сохраняю точки в коллекции;
function getCollectionCoords(customsCoords, collection, captions) {
    customsCoords.forEach(custom => {

        if (captions == 1) {
            collection.add(new ymaps.Placemark([custom['coordinates']['lat'], custom['coordinates']['lon']], {
                // balloonContent: 'цвет <strong>носика Гены</strong>',
                // hintContent: 'Ну давай уже тащи',
                // iconCaption: custom['properties']['iconCaption'],
                // balloonContentHeader: custom['properties']['balloonContentHeader'],
                // balloonContentBody: custom['properties']['balloonContentBody'],
                // balloonContentFooter: custom['properties']['balloonContentFooter'],
                // iconContent: 'Я тащусь',
                // iconCaption: custom['properties']['iconCaption'],
                iconContent: custom['properties']['iconCaption'],
            }));
        } else {
            collection.add(new ymaps.Placemark([custom['coordinates']['lat'], custom['coordinates']['lon']], {
            }));
        }

    });
}

// Проверяю есть ли данные для центра карты от поля поиска, если нет - задаю дефолтные значения;
if(!yandexMap.dataset.latitude && !yandexMap.dataset.longitude) {
    yandexMap.dataset.latitude = 57.76;
    yandexMap.dataset.longitude = 77.64;
}

// Инициализирую карту;
ymaps.ready(init);

function init () {
    var myMap = new ymaps.Map('map', {    
            center: [yandexMap.dataset.latitude, yandexMap.dataset.longitude],
            zoom: 4,
            controls: []
        }, {
            searchControlProvider: 'yandex#search'
        }),
        mainCollection = new ymaps.GeoObjectCollection(null, { // Создал коллекция Основных таможенных постов;
            preset: 'islands#greenStretchyIcon',
            // iconColor: 'green'
        }), 
        headCollection = new ymaps.GeoObjectCollection(null, { // Создал коллекция Головных таможенных постов;
            preset: 'islands#redStretchyIcon',
            // iconColor: 'red'
        }),
        exciseCollection = new ymaps.GeoObjectCollection(null, { // Создал коллекция Акцизных таможенных постов;
            preset: 'islands#yellowStretchyIcon',
            // iconColor: 'yellow'
        }),
        othersCollection = new ymaps.GeoObjectCollection(null, { // Создал коллекция Прочих таможенных постов;
            preset: 'islands#blueStretchyIcon',
            // iconColor: 'blue'
        })

        // Выполняю запрос при первом открытии страницы;
        $.ajax({
            url: 'http://localhost/wimc/web/checkbox' // "/ajax" // '/checkbox' "http://localhost/wimc/web/checkbox"
        }).done(function(response) {
            let customsCoords = JSON.parse(response);
            console.log(response);
            console.log(customsCoords);
            if (customsCoords['main'].length > 0) {
                getCollectionCoords(customsCoords['main'], mainCollection, data['captions']);
                myMap.geoObjects.add(mainCollection);
            }
        });

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
                        let customsCoords = JSON.parse(response);
                        console.log(response);
                        console.log(data);
                        console.log(customsCoords);

          

                        if (data['captions'] == 1) {
                            myMap.geoObjects.remove(mainCollection);
                            getCollectionCoords(customsCoords['main'], mainCollection, data['captions']);
                            myMap.geoObjects.add(mainCollection);
                        }

                        if (customsCoords['head'].length > 0) {
                            getCollectionCoords(customsCoords['head'], headCollection, data['captions']);
                            myMap.geoObjects.add(headCollection);
                        } else if(data['head'] == 0) {
                            myMap.geoObjects.remove(headCollection);
                        }

                        if (customsCoords['excise'].length > 0) {
                            getCollectionCoords(customsCoords['excise'], exciseCollection, data['captions']);
                            myMap.geoObjects.add(exciseCollection);
                        } else if(data['excise'] == 0) {
                            myMap.geoObjects.remove(exciseCollection);
                        }

                        if (customsCoords['others'].length > 0) {
                            getCollectionCoords(customsCoords['others'], othersCollection, data['captions']);
                            myMap.geoObjects.add(othersCollection);
                        } else if(data['others'] == 0) {
                            myMap.geoObjects.remove(othersCollection);
                        }

                        // if (data['captions'] == 1) {
                        //     if (customsCoords['main'].length > 0) {
                        //         myMap.geoObjects.remove(mainCollection);
                        //         getCollectionCoords(customsCoords['main'], mainCollection, data['captions']);
                        //         myMap.geoObjects.add(mainCollection);
                        //     }
                        //     if (customsCoords['head'].length > 0) {
                        //         myMap.geoObjects.remove(headCollection);
                        //         getCollectionCoords(customsCoords['head'], headCollection, data['captions']);
                        //         myMap.geoObjects.add(headCollection);
                        //     }
                        //     if (customsCoords['excise'].length > 0) {
                        //         myMap.geoObjects.remove(exciseCollection);
                        //         getCollectionCoords(customsCoords['excise'], exciseCollection, data['captions']);
                        //         myMap.geoObjects.add(exciseCollection);
                        //     }
                        //     if (customsCoords['others'].length > 0) {
                        //         myMap.geoObjects.remove(othersCollection);
                        //         getCollectionCoords(customsCoords['others'], othersCollection, data['captions']);
                        //         myMap.geoObjects.add(othersCollection);
                        //     }
                        // } else {
                        //     if (customsCoords['main'].length > 0) {
                        //         myMap.geoObjects.remove(mainCollection);
                        //         getCollectionCoords(customsCoords['main'], mainCollection, data['captions']);
                        //         myMap.geoObjects.add(mainCollection);
                        //     }
                        //     if (customsCoords['head'].length > 0) {
                        //         myMap.geoObjects.remove(headCollection);
                        //         getCollectionCoords(customsCoords['head'], headCollection, data['captions']);
                        //         myMap.geoObjects.add(headCollection);
                        //     }
                        //     if (customsCoords['excise'].length > 0) {
                        //         myMap.geoObjects.remove(exciseCollection);
                        //         getCollectionCoords(customsCoords['excise'], exciseCollection, data['captions']);
                        //         myMap.geoObjects.add(exciseCollection);
                        //     }
                        //     if (customsCoords['others'].length > 0) {
                        //         myMap.geoObjects.remove(othersCollection);
                        //         getCollectionCoords(customsCoords['others'], othersCollection, data['captions']);
                        //         myMap.geoObjects.add(othersCollection);
                        //     }
                        // }


                    }
                });
            }
        });
   
    }