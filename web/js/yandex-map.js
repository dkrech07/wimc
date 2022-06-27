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

            // Сделаем зум карты до двух точек (точки пользователя и ближайшего к ней поста);
            myMap.setBounds(searchCollection.getBounds()); 
            myMap.setZoom(myMap.getZoom()-2); //Чуть-чуть уменьшить зум для красоты

            // Наполняю всплывающее окно с результатами поиска;
            // var nearestPopupElement = document.querySelector('.nearest-popup');
            // var nearestList = nearestPopupElement.querySelector('.nearest-list');
            // var nearestOthers = nearestPopupElement.querySelector('.nearest-others');

            // nearestPopupElement.style.display = 'block';

            var nearestPopup = document.createElement('div');
            nearestPopup.className = 'nearest-popup';

            function getNearestPoint (point, containerElement) {
                var nearestItem = document.createElement('li');
                nearestItem.className = 'nearest-item';
    
                var nearestTitle = document.createElement('h4');
                nearestTitle.className = 'nearest-title';
                nearestTitle.textContent = point['namt'];
    
                var nearestDistance = document.createElement('div');
                nearestDistance.className = 'nearest-distance';
                nearestDistance.textContent = '~' + Math.floor(point['distance'] * 100000) + ' км.';
                
                var nearestName = document.createElement('div');
                nearestName.className = 'nearest-name';
                nearestName.textContent = point['namt'];
    
                var nearestAddress = document.createElement('div');
                nearestAddress.className = 'nearest-address';
                nearestAddress.textContent = point['adrtam'];
    
                nearestItem.append(nearestTitle);
                nearestItem.append(nearestDistance);
                nearestItem.append(nearestName);
                nearestItem.append(nearestAddress);
                nearestPopup.append(nearestItem);

                containerElement.append(nearestItem);
            }

            getNearestPoint(searchData['nearest_point'], nearestPopup);

            if (searchData['other_nearest_points'].length > 0) {

                searchData['other_nearest_points'].forEach(element => {
                    getNearestPoint(element, nearestPopup);

                });

            }

            document.body.append(nearestPopup);
        },
            // error: function(){
            //     alert('Error!');
            // }
        });
        return false;
    });
}

}

var questionFormElement = document.querySelector('#question-form');

if (questionFormElement) {
    var lettersCounterElement = questionFormElement.querySelector('.letters-counter');
    var lettersNumberElement = questionFormElement.querySelector('.letters-number');
    var formContentElement = questionFormElement.querySelector('#form_content');
    var needAnswerElement = questionFormElement.querySelector('#need-answer');
    var formEmailElement = questionFormElement.querySelector('.field-user_email');
    formEmailElement.value = 'Ответ не требуется';

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
    
}