







// ymaps.ready(init);

// function init() {
//     var myMap = new ymaps.Map('map', {
//         center: [yandexMap.dataset.latitude, yandexMap.dataset.longitude],
//         zoom: 3,
//         controls: ['zoomControl'] // , 'routeButtonControl' 'searchControl', 
//     }, {
//         searchControlProvider: 'yandex#search',
//     }),
//         nearestCollection = new ymaps.GeoObjectCollection(null, { // Коллекция для найденных точек (самая ближайшая точка);
//             preset: 'islands#orange'
//         }),
//         otherNearestCollection = new ymaps.GeoObjectCollection(null, { // Коллекция для найденных точек (две дополнительные ближайшие точки);
//             preset: 'islands#yellowIcon'
//         }),
//         clusterer = new ymaps.Clusterer({
//             minClusterSize: 2,
//             disableClickZoom: false,
//             groupByCoordinates: false,
//             clusterIconLayout: 'default#pieChart',
//             clusterIconPieChartRadius: 25,
//             clusterIconPieChartCoreRadius: 10,
//             clusterIconPieChartStrokeWidth: 3,
//             hasBalloon: true,
//             hideIconOnBalloonOpen: false,
//             clusterDisableClickZoom: true,
//             clusterOpenBalloonOnClick: false,
//         }),
//         // Объект с точками (разделенными по типу на массивы);
//         points = {
//             'main': [],
//             'head': [],
//             'excise': [],
//             'others': [],
//         },
//         geoObjects = {
//             'main': [],
//             'head': [],
//             'excise': [],
//             'others': [],
//         };

//     // Карта состояний чекбоксов;
//     var data = {
//         'main': 1,
//         'head': 0,
//         'excise': 0,
//         'others': 0,
//         'captions': 0,
//     };

//     // Карта цветов меток;
//     var pointsColors = {
//         'main': '#00AA00',
//         'head': '#FF0000',
//         'excise': '#0000FF',
//         'others': '#E8B000',
//     };


//     // Отрисовываю основные таможенные посты;
//     $.ajax({
//         url: '/checkbox',
//         type: 'POST',
//         data: data,
//         success: function (response) {
//             let customsCoords = JSON.parse(response);
//             getPoints(geoObjects['main'], customsCoords['main'], pointsColors['main'], data['captions']);
//             clusterer.add(geoObjects['main']);
//             myMap.geoObjects.add(clusterer);
//             myMap.setBounds(clusterer.getBounds(), {
//                 checkZoomRange: true
//             });
//         }
//     });




  


}

