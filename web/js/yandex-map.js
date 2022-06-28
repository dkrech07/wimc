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
        yandexMap.dataset.latitude = 37.76;
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
            minClusterSize: 2,
            disableClickZoom: false,
            groupByCoordinates: false,
            clusterIconLayout: 'default#pieChart',
            clusterIconPieChartRadius: 25,
            clusterIconPieChartCoreRadius: 10,
            clusterIconPieChartStrokeWidth: 3,
            hasBalloon: true,
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



        // Отрисовывает точки при поиске обеъкта на карте;
        $('#search-customs').on('beforeSubmit', function(){
            data['autocomplete'] = this['SearchCustoms[autocomplete]'].value;
            data['latitude'] = this['SearchCustoms[latitude]'].value;
            data['longitude'] = this['SearchCustoms[longitude]'].value;
    
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
                        if (searchListElement && evt.target.id !== 'autocomplete') {
                            searchListElement.style.display = 'none';
                        }
                    });
                    return;
                } else {
                    if (searchInputElement.classList.contains('input-alert')) {
                        searchInputElement.classList.remove('input-alert');
                        searchInputElement.classList.add('input-shadow');
                    }
                }

                //!!!!!!!!!!!!!!!!!!!!!!! ЗДЕСЬ ВЫПОЛНЯЕТСЯ ЗУМ К ТОЧКЕ ПОЛЬЗОВАТЕЛИ НАЙДЕННОМУ БЛИЖАЙШЕМУ ПОСТУ;
                // Сделаем зум карты до двух точек (точки пользователя и ближайшего к ней поста);
                // myMap.setBounds(searchCollection.getBounds()); 
                // myMap.setZoom(myMap.getZoom()-2); //Чуть-чуть уменьшить зум для красоты
            
                function getNearestInfo (item) {
                    var nearestItem = document.createElement('li');
                    nearestItem.className = 'nearest-item';

                    var nearestItemDistance = document.createElement('span');
                    nearestItemDistance.className = 'nearest-distance';
                    nearestItemDistance.textContent = '~' + Math.floor(item['distance'] * 100000) + ' км';

                    var nearestItemName = document.createElement('span');
                    nearestItemName.className = 'nearest-name';
                    nearestItemName.textContent = item['namt'];

                    var nearestItemAddress = document.createElement('span');
                    nearestItemAddress.className = 'nearest-address';
                    nearestItemAddress.textContent = item['adrtam'];

                    nearestItem.append(nearestItemDistance);
                    nearestItem.append(nearestItemName);
                    nearestItem.append(nearestItemAddress);

                    return nearestItem;
                }

                var nearestPopupElement = document.querySelector('.nearest-popup');
            
                // console.log(nearestPopupElement.classList);

                if (nearestPopupElement.classList.contains('nearest-active')) {
                    var nearestLists = nearestPopupElement.querySelectorAll('.nearest-list');

                    while (nearestLists[0].firstChild) {
                        nearestLists[0].removeChild(nearestLists[0].firstChild);
                    }

                    while (nearestLists[1].firstChild) {
                        nearestLists[1].removeChild(nearestLists[1].firstChild);
                    }

                    // nearestPopupElement.classList.remove('nearest-active');
                    // nearestPopupElement.classList.add('nearest-disabled');
                } else {
                    nearestPopupElement.classList.remove('nearest-disabled');
                    nearestPopupElement.classList.add('nearest-active');
                }

                if (nearestPopupElement.classList.contains('roll-down')) {
                    var nearestTitles = nearestPopupElement.querySelectorAll('.nearest-title');
                    var nearestLists = nearestPopupElement.querySelectorAll('.nearest-list');
                    var rollButtonElement = nearestPopupElement.querySelector('.roll-button');

                    nearestPopupElement.classList.remove('roll-down');
                    nearestPopupElement.classList.add('roll-up');

                    rollButtonElement.textContent = 'Развернуть';
        
                    nearestTitles.forEach(function (element) {
                        element.style.display = 'block';
                    });
        
                    nearestLists.forEach(function (element) {
                        element.style.display = 'block';
                    });
                }

                var nearestContainerElement = nearestPopupElement.querySelector('.nearest-list');
                var otherContainerElement = nearestPopupElement.querySelector('.nearest-others');

                nearestContainerElement.append(getNearestInfo(searchData['nearest_points'][0]));
                otherContainerElement.append(getNearestInfo(searchData['nearest_points'][1]));
                otherContainerElement.append(getNearestInfo(searchData['nearest_points'][2]));
            },
                // error: function(){
                //     alert('Error!');
                // }
            });
            return false;
        });




    }
}

// var questionFormElement = document.querySelector('#question-form');

// if (questionFormElement) {
//     var lettersCounterElement = questionFormElement.querySelector('.letters-counter');
//     var lettersNumberElement = questionFormElement.querySelector('.letters-number');
//     var formContentElement = questionFormElement.querySelector('#form_content');
//     var needAnswerElement = questionFormElement.querySelector('#need-answer');
//     var formEmailElement = questionFormElement.querySelector('.field-user_email');
//     formEmailElement.value = 'Ответ не требуется';

//     needAnswerElement.addEventListener('click', evt => {
//         var check = needAnswerElement.checked ? 1:0;
//         if (check === 1) {
//             formEmailElement.style = "display: block;"
//             formEmailElement.setAttribute("required", true);
//         } else {
//             formEmailElement.style = "display: none;"
//             formEmailElement.setAttribute("required", false);
//         }
//     });

//     formContentElement.addEventListener('input', evt => {
//         lettersNumberElement.textContent = formContentElement.value.length;

//         if (formContentElement.value.length > 1000) {
//             lettersCounterElement.style.color='red';
//         } else {
//             lettersCounterElement.style.color='black';

//         }
//       });
    
// }
