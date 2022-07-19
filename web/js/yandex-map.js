const yandexMap = document.querySelector('#map');

if (!yandexMap.dataset.latitude && !yandexMap.dataset.longitude) {
    yandexMap.dataset.latitude = 37.76;
    yandexMap.dataset.longitude = 77.64;
}

ymaps.ready(init);

function init() {
    var myMap = new ymaps.Map('map', {
        center: [yandexMap.dataset.latitude, yandexMap.dataset.longitude],
        zoom: 3,
        controls: ['zoomControl'] // , 'routeButtonControl' 'searchControl', 
    }, {
        searchControlProvider: 'yandex#search',
                    // preset: 'islands#orange'

    }),
        searchCollection = new ymaps.GeoObjectCollection(null, { // Коллекция для найденных точек (самая ближайшая точка);
            preset: 'islands#orange'
        }),
        // otherNearestCollection = new ymaps.GeoObjectCollection(null, { // Коллекция для найденных точек (две дополнительные ближайшие точки);
        //     preset: 'islands#yellowIcon'
        // }),
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
        });
    // Объект с точками (разделенными по типу на массивы);
    // points = {
    //     'main': [],
    //     'head': [],
    //     'excise': [],
    //     'others': [],
    // },
    //     'main': [],
    //     'head': [],
    //     'excise': [],
    //     'others': [],
    // };

    // Карта состояний чекбоксов;
    var data = {
        'head': 0,
        'excise': 0,
        'others': 0,
        'captions': 0,
        'autocomplete': null,
        'latitude': null,
        'longitude': null,
    };

    // Отрисовываю основные таможенные посты;
    window.points.getData(data, clusterer, searchCollection, myMap);

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

            window.points.getData(data, clusterer, searchCollection, myMap);
        }
    });

    // Отрисовывает точки при поиске обеъкта на карте;
    $('#search-customs').on('beforeSubmit', function () {
        data['autocomplete'] = this['SearchCustoms[autocomplete]'].value;
        data['latitude'] = this['SearchCustoms[latitude]'].value;
        data['longitude'] = this['SearchCustoms[longitude]'].value;

        window.points.getData(data, clusterer, searchCollection, myMap);
        return false;
    });

    window.points.checkClusterPoints(myMap, clusterer);
    window.points.zoomOut(myMap, clusterer);



}