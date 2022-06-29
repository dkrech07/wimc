const yandexMap = document.querySelector('#map');

ymaps.ready(init);

function init() {
    var myMap = new ymaps.Map('map', {
        center: [yandexMap.dataset.latitude, yandexMap.dataset.longitude],
        zoom: 3,
        controls: ['zoomControl'] // , 'routeButtonControl' 'searchControl', 
    }, {
        searchControlProvider: 'yandex#search',
    }),
        nearestCollection = new ymaps.GeoObjectCollection(null, { // Коллекция для найденных точек (самая ближайшая точка);
            preset: 'islands#orange'
        }),
        otherNearestCollection = new ymaps.GeoObjectCollection(null, { // Коллекция для найденных точек (две дополнительные ближайшие точки);
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
        // points = {
        //     'main': [],
        //     'head': [],
        //     'excise': [],
        //     'others': [],
        // },
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
            window.points.getPoints(geoObjects['main'], customsCoords['main'], pointsColors['main'], data['captions']);
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
    
    checkboxes.forEach(function (checkbox, i) {
        checkbox.onchange = function () {
            checkboxes.forEach(function (checkbox) {
                data[checkbox.id] = checkbox.checked ? 1 : 0;
            });
    
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
    
                        window.points.getPoints(geoObjects[checkbox.id], customsCoords[checkbox.id], pointsColors[checkbox.id], data['captions']);
    
                        clusterer.add(geoObjects[checkbox.id]);
                        myMap.geoObjects.add(clusterer);
                    } else if (checkbox.id == 'captions') {
                        clusterer.removeAll();
    
                        if (data['main'] == 1) {
                            window.points.getPoints(geoObjects['main'], customsCoords['main'], pointsColors['main'], data['captions']);
                            clusterer.add(geoObjects['main']);
                        }
    
                        if (data['head'] == 1) {
                            window.points.getPoints(geoObjects['head'], customsCoords['head'], pointsColors['head'], data['captions']);
                            clusterer.add(geoObjects['head']);
                        }
    
                        if (data['excise'] == 1) {
                            window.points.getPoints(geoObjects['excise'], customsCoords['excise'], pointsColors['excise'], data['captions']);
                            clusterer.add(geoObjects['excise']);
                        }
    
                        if (data['others'] == 1) {
                            window.points.getPoints(geoObjects['others'], customsCoords['others'], pointsColors['others'], data['captions']);
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

    window.points.checkClusterPoints(myMap, clusterer);
    window.points.zoomOut(myMap, clusterer);

    
    
 
}