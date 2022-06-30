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
        'autocomplete': null,
        'latitude': null,
        'longitude': null,
    };

    // Отрисовываю основные таможенные посты;
    window.points.getData(data, geoObjects, clusterer, myMap);

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

            window.points.getData(data, geoObjects, clusterer, myMap);
        }
    });

    // Отрисовывает точки при поиске обеъкта на карте;
    $('#search-customs').on('beforeSubmit', function () {
        data['autocomplete'] = this['SearchCustoms[autocomplete]'].value;
        data['latitude'] = this['SearchCustoms[latitude]'].value;
        data['longitude'] = this['SearchCustoms[longitude]'].value;

        window.points.getData(data, geoObjects, clusterer, myMap);
        return false;
    });

    window.points.checkClusterPoints(myMap, clusterer);
    window.points.zoomOut(myMap, clusterer);
    //     $.ajax({
    //         url: '/search',
    //         type: 'POST',
    //         data: data,
    //         success: function (response) {
    //             let searchData = JSON.parse(response);

    //             // console.log('вывожу в консоль результат поиска точки'); // вывожу в консоль результат поиска точки
    //             // console.log(searchData); // вывожу в консоль результат поиска точки



    //             function getNearestInfo(item) {
    //                 var nearestItem = document.createElement('li');
    //                 nearestItem.className = 'nearest-item';

    //                 var nearestItemDistance = document.createElement('span');
    //                 nearestItemDistance.className = 'nearest-distance';
    //                 nearestItemDistance.textContent = '~' + Math.floor(item['distance'] * 100000) + ' км';

    //                 var nearestItemName = document.createElement('span');
    //                 nearestItemName.className = 'nearest-name';
    //                 nearestItemName.textContent = item['namt'];

    //                 var nearestItemAddress = document.createElement('span');
    //                 nearestItemAddress.className = 'nearest-address';
    //                 nearestItemAddress.textContent = item['adrtam'];

    //                 nearestItem.append(nearestItemDistance);
    //                 nearestItem.append(nearestItemName);
    //                 nearestItem.append(nearestItemAddress);

    //                 return nearestItem;
    //             }

    //             var nearestPopupElement = document.querySelector('.nearest-popup');
    //             if (nearestPopupElement.classList.contains('nearest-active')) {
    //                 var nearestLists = nearestPopupElement.querySelectorAll('.nearest-list');
    //                 while (nearestLists[0].firstChild) {
    //                     nearestLists[0].removeChild(nearestLists[0].firstChild);
    //                 }
    //                 while (nearestLists[1].firstChild) {
    //                     nearestLists[1].removeChild(nearestLists[1].firstChild);
    //                 }
    //             } else {
    //                 nearestPopupElement.classList.remove('nearest-disabled');
    //                 nearestPopupElement.classList.add('nearest-active');
    //             }

    //             if (nearestPopupElement.classList.contains('roll-down')) {
    //                 var nearestTitles = nearestPopupElement.querySelectorAll('.nearest-title');
    //                 var nearestLists = nearestPopupElement.querySelectorAll('.nearest-list');
    //                 var rollButtonElement = nearestPopupElement.querySelector('.roll-button');

    //                 nearestPopupElement.classList.remove('roll-down');
    //                 nearestPopupElement.classList.add('roll-up');

    //                 rollButtonElement.textContent = 'Развернуть';

    //                 nearestTitles.forEach(function (element) {
    //                     element.style.display = 'block';
    //                 });

    //                 nearestLists.forEach(function (element) {
    //                     element.style.display = 'block';
    //                 });
    //             }

    //             var nearestContainerElement = nearestPopupElement.querySelector('.nearest-list');
    //             var otherContainerElement = nearestPopupElement.querySelector('.nearest-others');
    //             nearestContainerElement.append(getNearestInfo(searchData['nearest_points'][0]));
    //             otherContainerElement.append(getNearestInfo(searchData['nearest_points'][1]));
    //             otherContainerElement.append(getNearestInfo(searchData['nearest_points'][2]));
    //         }
    //     });
    //     return false;



}