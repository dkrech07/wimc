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

    $.ajax({
        url: "/ajax"
    }).done(function(data) {
        objectManager.add(data);
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
        url: '/customs/search',
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

            myMap.geoObjects.add(new ymaps.Placemark([geo['nearest_lat'], geo['nearest_lon']], {
                balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
            }, {
                preset: 'islands#icon',
                iconColor: 'red'
            }));

        myMap.setCenter([geo['latitude'], geo['longitude']]);
        myMap.setZoom(14);
        
        // myMap.setBounds(myCollection.getBounds(),{checkZoomRange:true, zoomMargin:9});
                   // if (object.status == "free") {
            //     objectManager.objects.setObjectOptions(object.id, {
            //       preset: 'islands#greenAutoIcon'
            //     });
            // }

        console.log('Ответ при отправке формы:');
        console.log(res);
        // console.log('Точка');
        // console.log(geo['latitude']);
        // console.log(geo['longitude']);
        },
        error: function(){
        alert('Error!');
        }
        });
        return false;
    });


}