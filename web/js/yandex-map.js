const yandexMap = document.querySelector('#map');

if(!yandexMap.dataset.latitude && !yandexMap.dataset.longitude) {
    yandexMap.dataset.latitude = 55.76;
    yandexMap.dataset.longitude = 37.64;
}

ymaps.ready(init);

function init () {
    var myMap = new ymaps.Map('map', {
            // center: [55.76, 37.64],
        
            center: [yandexMap.dataset.latitude, yandexMap.dataset.longitude],
            zoom: 5,
            controls: []
        }, {
            searchControlProvider: 'yandex#search'
        }),

        clusterer = new ymaps.Clusterer({
            // Макет метки кластера pieChart.
            clusterIconLayout: 'default#pieChart',
            // Радиус диаграммы в пикселях.
            clusterIconPieChartRadius: 25,
            // Радиус центральной части макета.
            clusterIconPieChartCoreRadius: 10,
            // Ширина линий-разделителей секторов и внешней обводки диаграммы.
            clusterIconPieChartStrokeWidth: 3,
            // Определяет наличие поля balloon.
            hasBalloon: false
        }),
        
        objectManager = new ymaps.ObjectManager({
            // Чтобы метки начали кластеризоваться, выставляем опцию.
            clusterize: true,
            // ObjectManager принимает те же опции, что и кластеризатор.
            gridSize: 32,
            clusterDisableClickZoom: true
        });

    // Чтобы задать опции одиночным объектам и кластерам,
    // обратимся к дочерним коллекциям ObjectManager.
    objectManager.objects.options.set('preset', 'islands#greenDotIcon');
    objectManager.clusters.options.set('preset', 'islands#greenClusterIcons');
    myMap.geoObjects.add(objectManager);
    
    console.log(objectManager.objects.options);

    // myMap.geoObjects.add(new ymaps.Placemark([55.642063, 37.656123], {
    //     balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
    // }, {
    //     preset: 'islands#icon',
    //     iconColor: '#0095b6'
    // }));

    // myMap.geoObjects.add(new ymaps.Placemark(yandexMap.dataset.latitude, yandexMap.dataset.longitude, {
    //                 balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
    //             }, {
    //                 preset: 'islands#icon',
    //                 iconColor: '#0095b6'
    //             }));

    var data = {
        'main': 0,
        'head': 1,
        'excise': 1,
        'others': 1,
        'captions': 0,
     };
     
    // $.ajax({
    //     url: "http://localhost/wimc/web/checkbox"
    // }).done(function(data) {
    //     objectManager.add(data);
    // });
    
    // Отрисовываю основные таможенные посты;
    $.ajax({
        url: 'http://localhost/wimc/web/checkbox', // '/checkbox' 'http://localhost/wimc/web/checkbox'
        type: 'POST',
        data: data,
        success: function (response) {
            // let customsCoords = JSON.parse(response);
            objectManager.add(response);
            // console.log(response);
            console.log(data);

    }
    });

    // $.ajax({
    //     url: "http://localhost/wimc/web/customs/search"
    // }).done(function(data) {
    //     console.log('Пришло от Яндекс Карт:');
    //     // let geo = JSON.parse(data);

    //     console.log(data);
     


    //     // myMap.geoObjects.add(new ymaps.Placemark([geo['lat'], geo['lon']], {
    //     //     balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
    //     // }, {
    //     //     preset: 'islands#icon',
    //     //     iconColor: 'red'
    //     // }));
        
    // });

    // let userPoint = document.querySelector('');

    // $.ajax(
    //     'http://localhost/wimc/web/customs/search',
    //     {
    //         success: function(data) {
    //           alert('AJAX call was successful!');
    //           alert('Data from the server' + data);
    //         },
    //         error: function() {
    //           alert('There was some error performing the AJAX call!');
    //         }
    //      }
    //   );

    $('#search-customs').on('beforeSubmit', function(){
        var data = $(this).serialize();
        $.ajax({
        url: 'http://localhost/wimc/web/customs/search',
        type: 'POST',
        data: data,
        success: function(res){
            let geo = JSON.parse(res);

            myMap.geoObjects.add(new ymaps.Placemark([geo['latitude'], geo['longitude']], {
                balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
            }, {
                preset: 'islands#icon',
                iconColor: 'red'
            }));

        myMap.setCenter([geo['latitude'], geo['longitude']]);
        myMap.setZoom(14);

        console.log('Ответ при отправке формы:');
        console.log(res);
        console.log('Точка');
        console.log(geo['latitude']);
        console.log(geo['longitude']);
        },
        error: function(){
        alert('Error!');
        }
        });
        return false;
    });


}
