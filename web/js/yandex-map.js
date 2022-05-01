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
        searchCollection = new ymaps.GeoObjectCollection(null, { // Создал коллекция для найденных точек (одна пользовательская, вторая ближайшая);
            preset: 'islands#yellowIcon'
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


    $.ajax({
        url: "/customs/ajax"
    }).done(function(data) {
        objectManager.add(data);
    });

    $('#search-customs').on('beforeSubmit', function(){
        var data = $(this).serialize();
        $.ajax({
        url: '/customs/search',
        type: 'POST',
        data: data,
        success: function(res){
            let geo = JSON.parse(res);

            searchCollection.removeAll();
            searchCollection.add(new ymaps.Placemark([geo['latitude'], geo['longitude']], {
                balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
            }, {
                preset: 'islands#icon',
                iconColor: 'red'
            }));
            searchCollection.add(new ymaps.Placemark([geo['nearest_lat'], geo['nearest_lon']]));

            myMap.geoObjects.add(searchCollection);


        // Добавляем на карту метку пользователя
            // myMap.geoObjects.add(new ymaps.Placemark([geo['latitude'], geo['longitude']], {
            //     balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
            // }, {
            //     preset: 'islands#icon',
            //     iconColor: 'red'
            // }));

            // myMap.geoObjects.add(new ymaps.Placemark([geo['nearest_lat'], geo['nearest_lon']], {
            //     balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
            // }, {
            //     preset: 'islands#icon',
            //     iconColor: 'red'
            // }));

        // Добавляем на карту круг 

        var myCircle = new ymaps.Circle([
            // Координаты центра круга.
            [geo['latitude'], geo['longitude']],
            // Радиус круга в метрах.
            geo['distance']
        ], {
            // Описываем свойства круга.
            // Содержимое балуна.
            balloonContent: "Радиус круга - 10 км",
            // Содержимое хинта.
            hintContent: "Подвинь меня"
        }, {
            // Задаем опции круга.
            // Включаем возможность перетаскивания круга.
            draggable: false,
            // Цвет заливки.
            // Последний байт (77) определяет прозрачность.
            // Прозрачность заливки также можно задать используя опцию "fillOpacity".
            fillColor: "#DB709377",
            // Цвет обводки.
            strokeColor: "#990066",
            // Прозрачность обводки.
            strokeOpacity: 0.8,
            // Ширина обводки в пикселях.
            strokeWidth: 5
        });
    


        
        console.log('Новый центр карты:');
        console.log([geo['latitude'], geo['longitude']]);
        // myMap.panTo(
        //     // Координаты нового центра карты
        //     [geo['latitude'], geo['longitude']], {
        //         /* Опции перемещения:
        //            разрешить уменьшать и затем увеличивать зум
        //            карты при перемещении между точками 
        //         */
        //         flying: true
        //     }
        // )

        // myMap.setZoom(14);
        
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


                // Добавляем круг на карту.
                myMap.geoObjects.add(myCircle);
                // Отцентруем карту по точке пользователя;
                myMap.setCenter([geo['latitude'], geo['longitude']]);
                // Сделаем зум карты до двух точек (точки пользователя и ближайшего к ней поста);
                myMap.setBounds(searchCollection.getBounds()); 
                myMap.setZoom(myMap.getZoom()-2); //Чуть-чуть уменьшить зум для красоты

                // myMap.setBounds(myMap.searchCollection.getBounds())
        },
        error: function(){
        alert('Error!');
        }
        });
        return false;
    });


    
}