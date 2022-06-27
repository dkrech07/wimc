// Start
const yandexMap = document.querySelector('#map');

if (yandexMap) {
    var zoomOutButtonElement = document.querySelector('.zoom-out');

function getPoints(geoObjects, points, color, captions) {
        for (var i = 0, len = points.length; i < len; i++) {
            if (captions == 1) {
                geoObjects[i] = new ymaps.Placemark([points[i]['coordinates']['lat'], points[i]['coordinates']['lon']], 
                {
                    iconCaption: points[i]['properties']['iconCaption'],
                    balloonContentHeader: points[i]['properties']['balloonContentHeader'],
                    balloonContentBody: points[i]['properties']['balloonContentBody'],
                    balloonContentFooter: points[i]['properties']['balloonContentFooter'],
                }, {
                    iconColor: color,
                    hideIconOnBalloonOpen: false,
                    balloonOffset: [3, -25],
                });
            } else {
                geoObjects[i] = new ymaps.Placemark([points[i]['coordinates']['lat'], points[i]['coordinates']['lon']], 
                {
                    balloonContentHeader: points[i]['properties']['balloonContentHeader'],
                    balloonContentBody: points[i]['properties']['balloonContentBody'],
                    balloonContentFooter: points[i]['properties']['balloonContentFooter'],
                }, {
                    iconColor: color,
                    hideIconOnBalloonOpen: false,
                    balloonOffset: [3, -25],
                });
            }

        }
}

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
        controls: ['zoomControl'] // , 'routeButtonControl' 'searchControl', 
    }, {
        searchControlProvider: 'yandex#search',
    }),
    searchCollection = new ymaps.GeoObjectCollection(null, { // Коллекция для найденных точек (одна пользовательская, вторая ближайшая);
        preset: 'islands#yellowIcon'
    }),
    clusterer = new ymaps.Clusterer({
        // clusterBalloonLeftColumnWidth: 225,
        // Размер ячейки кластеризации в пикселях. Значение должно быть равно 2^n;
        // gridSize: 50, 
        // Флаг наличия у кластеризатора поля .hint;
        // hasHint: true,
        // Минимальное количество объектов, образующих кластер;
        minClusterSize: 2,
        // Флаг, запрещающий увеличение коэффициента масштабирования карты при клике на кластер;
        disableClickZoom: false,
        // Группировка точек в кластеры по координатам;
        groupByCoordinates: false,
        // Макет метки кластера pieChart;
        clusterIconLayout: 'default#pieChart',
        // Радиус диаграммы в пикселях;
        clusterIconPieChartRadius: 25,
        // Радиус центральной части макета;
        clusterIconPieChartCoreRadius: 10,
        // Ширина линий-разделителей секторов и внешней обводки диаграммы;
        clusterIconPieChartStrokeWidth: 3,
        // Определяет наличие поля balloon;
        hasBalloon: true,
        // Скрывать иконку при открытии балуна;
        hideIconOnBalloonOpen: false,
        clusterDisableClickZoom: true,
        clusterOpenBalloonOnClick: false,
    }),
    // Объект с точками (разделенными по типу на массивы);
        points = {
            'main': [],
            'head': [],
            'excise': [],
            'others': [],
        },
        geoObjects = {
            'main': [],
            'head': [],
            'excise': [],
            'others': [],
        };

    // Карта состояний чекбоксов;
    var data = {
        'main': 1,
        'head': 0,
        'excise': 0,
        'others': 0,
        'captions': 0,
     };

     // Карта цветов меток;
     var pointsColors = {
        'main': '#00AA00',
        'head': '#FF0000',
        'excise': '#0000FF',
        'others': '#E8B000',
     };

  // Отрисовываю основные таможенные посты;
  $.ajax({
    url: '/checkbox',
    type: 'POST',
    data: data,
    success: function (response) {
        let customsCoords = JSON.parse(response);
        getPoints(geoObjects['main'], customsCoords['main'], pointsColors['main'], data['captions']);
        clusterer.add(geoObjects['main']);
        myMap.geoObjects.add(clusterer);
        console.log(myMap.geoObjects);
        myMap.setBounds(clusterer.getBounds(), {
            checkZoomRange: true
        });
}
});

    // Отрысовывает точки при фильтрации по типам постов;
    let checkboxes = Array.from(document.querySelectorAll('.customs-checkbox'));

    let toggleGroupList = document.querySelector('.btn-group-toggle');
    let labelElements = toggleGroupList.querySelectorAll('label');

    checkboxes.forEach(function(checkbox, i) {
        checkbox.onchange = function() {
            checkboxes.forEach(function(checkbox){
                data[checkbox.id] = checkbox.checked ? 1:0;

                // checkbox.style.boxShadow = 'none';

                // lableElements[i].style.boxShadow = 'none';
            });

            console.log(labelElements[i]);
            if (checkbox.checked == 1) {
                labelElements[i].style.boxShadow = 'none';
            } else {
                labelElements[i].style.boxShadow = '4px 4px 4px rgb(109, 106, 104)';
            }


            $.ajax({
                url: '/checkbox', 
                type: 'POST',
                data: data,
                success: function (response) {
                    let customsCoords = JSON.parse(response);

                    if (data[checkbox.id] == 1 && checkbox.id !== 'captions') {

                        getPoints(geoObjects[checkbox.id], customsCoords[checkbox.id], pointsColors[checkbox.id], data['captions']);

                        clusterer.add(geoObjects[checkbox.id]);
                        myMap.geoObjects.add(clusterer);
                    } else if (checkbox.id == 'captions') {
                            clusterer.removeAll();

                            if (data['main'] == 1) {
                                getPoints(geoObjects['main'], customsCoords['main'], pointsColors['main'], data['captions']);
                                clusterer.add(geoObjects['main']);
                            }

                            if (data['head'] == 1) {
                                getPoints(geoObjects['head'], customsCoords['head'], pointsColors['head'], data['captions']);
                                clusterer.add(geoObjects['head']);
                            }

                            if (data['excise'] == 1) {
                                getPoints(geoObjects['excise'], customsCoords['excise'], pointsColors['excise'], data['captions']);
                                clusterer.add(geoObjects['excise']);
                            }

                            if (data['others'] == 1) {
                                getPoints(geoObjects['others'], customsCoords['others'], pointsColors['others'], data['captions']);
                                clusterer.add(geoObjects['others']);
                            }

                            myMap.geoObjects.add(clusterer);
                    } else {
                        clusterer.remove(geoObjects[checkbox.id]);
                    }
                }
            });
        }
    });

    function checkClusterPoints() {
        clusterer.events.add('click', function (e) {
            // получаем ссылку на объект, по которому кликнули
            var cluster = e.get('target');
            if (cluster.options._name == 'cluster') {
                var clusterPoints = cluster.getGeoObjects();

                var pointsCoordinates = []; // список всех точек координат кластера;
                clusterPoints.forEach(point => {
                    pointsCoordinates.push(point.geometry._coordinates);
                });

                for(var i = 0; i < pointsCoordinates.length; i++){
                    currentPoint = pointsCoordinates[i];
                    for(var j = 0; j < pointsCoordinates.length; j++){
                        checkPoint = pointsCoordinates[j];

                        if (currentPoint[0] != checkPoint[0] || currentPoint[1] != checkPoint[1]) {
                            myMap.setCenter(pointsCoordinates[0]);
                            myMap.setBounds(cluster.getBounds()); 
                            return;
                        }
                    }
                }
                clusterer.balloon.open(cluster);

            }            
        });
    }
    
    checkClusterPoints();
    
    zoomOutButtonElement.addEventListener('click', (evt)=>{
        myMap.setCenter([57.76, 77.64]);
        myMap.setBounds(clusterer.getBounds()); 
    });

    // var searchBtn = document.querySelector('.search-btn');

    // searchBtn.addEventListener('click', evt => {
    //     var searchInputElement = document.querySelector('#autocomplete');
    //     var latElement = document.querySelector('.field-latitude');

    //     latElement.classList.forEach(item => {
    //         if (item == 'has-error') {
    //             searchInputElement.classList.add('input-alert');
    //         }
    //     });
    //     console.log(latElement.classList);


    // var searchInputElement = document.querySelector('#autocomplete')
    // searchInputElement.classList.add('input-alert');

    // });

   // Отрисовывает точки при поиске обеъкта на карте;
   $('#search-customs').on('beforeSubmit', function(){
        data['latitude'] = this['SearchCustoms[latitude]'].value;
        data['longitude'] = this['SearchCustoms[longitude]'].value;
        data['nearest_lat'] = this['SearchCustoms[nearest_lat]'].value;
        data['nearest_lon'] = this['SearchCustoms[nearest_lon]'].value;
        data['distance'] = this['SearchCustoms[distance]'].value;
        data['autocomplete'] = this['SearchCustoms[autocomplete]'].value;

        $.ajax({
            url: '/search', 
        type: 'POST',
        data: data,
        success: function(response){
            let searchData = JSON.parse(response);

            console.log('вывожу в консоль результат поиска точки'); // вывожу в консоль результат поиска точки

            console.log(searchData); // вывожу в консоль результат поиска точки
            
            var searchInputElement = document.querySelector('#autocomplete');

            if (!searchData) {
                searchInputElement.classList.remove('input-shadow');
                searchInputElement.classList.add('input-alert');

                var searchListElement = document.querySelector('#ui-id-1');
                searchListElement.style.width = searchInputElement.offsetWidth + 'px';
                searchListElement.style.top = $('#autocomplete').offset()['top'] + 36 + 'px';
                searchListElement.style.left = '50%';
                searchListElement.style.marginLeft = -searchInputElement.offsetWidth / 2 + 'px';

                
                searchListElement.style.display = 'block';
                while (searchListElement.firstChild) {
                    searchListElement.removeChild(searchListElement.firstChild);
                }
                var noResultsElement = document.createElement('li');
                noResultsElement.className = "no-results-item"; //ui-menu-item
                noResultsElement.innerHTML = "<span tabindex='-1' class='no-results ui-menu-item-wrapper'><i style='color: #6c757d'>Ничего не нашлось... Попробуйте изменить или дополнить запрос</i></span>";
                searchListElement.append(noResultsElement);

                document.addEventListener('click', evt => {
                    // evt.preventDefault();
                    // noResultsElement.remove();
                    if (searchListElement && evt.target.id !== 'autocomplete') {
                        searchListElement.style.display = 'none';
                    }
                });

                // $('#autocomplete').on('click', function() {
                //     // searchBtn.style.boxShadow = 'none';
                
                //     var searchListElement = document.querySelector('#ui-id-1');
                //     searchListElement.style.width = searchInputElement.offsetWidth + 'px';
                //     if (searchListElement && searchInputElement.value) {
                //       searchListElement.style.display = 'block';
                //     }
                //   });
                return;
            } else {
                if (searchInputElement.classList.contains('input-alert')) {
                    searchInputElement.classList.remove('input-alert');
                    searchInputElement.classList.add('input-shadow');
                }
            }

            

            searchCollection.removeAll();
            
            searchCollection.add(new ymaps.Placemark([searchData['latitude'], searchData['longitude']], {
                balloonContentHeader: 'Вы искали:',
                balloonContentBody: searchData['geo'],
                balloonContentFooter: 'Координаты точки: ' + searchData['latitude'] + ', ' + searchData['longitude'],
                iconCaption: 'Ваша точка',
            }, {
                preset: 'islands#pinkDotIcon',
                iconColor: 'red',
            }));

            searchCollection.add(new ymaps.Placemark([searchData['nearest_lat'], searchData['nearest_lon']]));

            myMap.geoObjects.add(searchCollection);

            // // Отцентруем карту по точке пользователя;
            // // console.log('Новый центр карты:');
            // // console.log([geo['latitude'], geo['longitude']]);
            // myMap.setCenter([geo['latitude'], geo['longitude']]);
            
            // // Сделаем зум карты до двух точек (точки пользователя и ближайшего к ней поста);
            myMap.setBounds(searchCollection.getBounds()); 
            myMap.setZoom(myMap.getZoom()-2); //Чуть-чуть уменьшить зум для красоты
        },
            // error: function(){
            //     alert('Error!');
            // }
        });
        return false;
    });
}

// End
}

var questionFormElement = document.querySelector('#question-form');

if (questionFormElement) {
    var lettersCounterElement = questionFormElement.querySelector('.letters-counter');
    var lettersNumberElement = questionFormElement.querySelector('.letters-number');
    var formContentElement = questionFormElement.querySelector('#form_content');
    var needAnswerElement = questionFormElement.querySelector('#need-answer');
    var formEmailElement = questionFormElement.querySelector('.field-user_email');
    formEmailElement.value = 'Ответ не требуется';

    // formEmailElement.style = "display: none;"

    needAnswerElement.addEventListener('click', evt => {
        var check = needAnswerElement.checked ? 1:0;
        if (check === 1) {
            formEmailElement.style = "display: block;"
            formEmailElement.setAttribute("required", true);
        } else {
            formEmailElement.style = "display: none;"
            formEmailElement.setAttribute("required", false);
        }
    });

    formContentElement.addEventListener('input', evt => {
        lettersNumberElement.textContent = formContentElement.value.length;

        if (formContentElement.value.length > 1000) {
            lettersCounterElement.style.color='red';
        } else {
            lettersCounterElement.style.color='black';

        }
      });
    
    // lettersNumberElement.value = textInputElement.value;
    // console.log('ok');
}











// if (data[checkbox.id] == 1 && checkbox.id !== 'captions') {
//     let customsCoords = JSON.parse(response);
//     getCollectionCoords(customsCoords[checkbox.id], customsMap[checkbox.id], data['captions']);
//     myMap.geoObjects.add(customsMap[checkbox.id]);
// } else if (checkbox.id == 'captions') {
//     let customsCoords = JSON.parse(response);

    // if (data[checkbox.id] != captionsFlag) {
    //     // myMap.geoObjects.removeAll();
    //     captionsFlag = data[checkbox.id];
    // }

//     if (mainPoints.getLength() > 0) {

//         getCollectionCoords(customsCoords['main'], customsMap['main'], data['captions']);
//         myMap.geoObjects.add(customsMap['main']);
//     }
//     if (headPoints.getLength() > 0) {
//         myMap.geoObjects.remove(customsMap['head']);

//         getCollectionCoords(customsCoords['head'], customsMap['head'], data['captions']);
//         myMap.geoObjects.add(customsMap['head']);
//     }
//     if (excisePoints.getLength() > 0) {
//         myMap.geoObjects.remove(customsMap['excise']);

//         getCollectionCoords(customsCoords['excise'], customsMap['excise'], data['captions']);
//         myMap.geoObjects.add(customsMap['excise']);
//     }
//     if (othersPoints.getLength() > 0) {
//         myMap.geoObjects.remove(customsMap['others']);

//         getCollectionCoords(customsCoords['others'], customsMap['others'], data['captions']);
//         myMap.geoObjects.add(customsMap['others']);
//     }
    
// } else {
//     myMap.geoObjects.remove(customsMap[checkbox.id]);
// }

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

  

  
        // function getCollectionCoords(customsCoords, points) {
//     customsCoords.forEach(custom => {
//         points.push([custom['coordinates']['lat'], custom['coordinates']['lon']]);
//     });
// }
 





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