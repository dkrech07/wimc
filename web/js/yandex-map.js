const yandexMap = document.querySelector('#map');

function getCountsCount (response) {
    let costomsObj = JSON.parse(response);

    var customsCountElement = document.querySelector('.customs-number');
    customsCountElement.textContent = costomsObj['customs_count'];
}

if(!yandexMap.dataset.latitude && !yandexMap.dataset.longitude) {
    yandexMap.dataset.latitude = 55.76;
    yandexMap.dataset.longitude = 37.64;
}

ymaps.ready(init);

function init () {
    var myMap = new ymaps.Map('map', {    
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

    // Отрисовывает точки при поиске обеъкта на карте;
    $('#search-customs').on('beforeSubmit', function(){
        var data = $(this).serialize();
        $.ajax({
        url: 'http://localhost/wimc/web/search', // 'http://localhost/wimc/web/search'
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

            // Отцентруем карту по точке пользователя;
            console.log('Новый центр карты:');
            console.log([geo['latitude'], geo['longitude']]);
            myMap.setCenter([geo['latitude'], geo['longitude']]);
            
            // Сделаем зум карты до двух точек (точки пользователя и ближайшего к ней поста);
            myMap.setBounds(searchCollection.getBounds()); 
            myMap.setZoom(myMap.getZoom()-2); //Чуть-чуть уменьшить зум для красоты
        },
        error: function(){
        alert('Error!');
        }
        });
        return false;
    });

    // Отприсовывает точки при загрузке страницы;

    $.ajax({
        url: 'http://localhost/wimc/web/checkbox' // "/ajax" // '/checkbox' "http://localhost/wimc/web/checkbox"
    }).done(function(response) {
        objectManager.add(response);
        getCountsCount(response)
        console.log(response);
    });


    // Отрысовывает точки при фильтрации по типам постов;
    let checkboxes = Array.from(document.querySelectorAll('.customs-checkbox'));
    var data = {};
    checkboxes.forEach(function(checkbox, i) {
        checkbox.onchange = function() {
            checkboxes.forEach(function(checkbox){
                data[checkbox.id] = checkbox.checked ? 1:0;
            });
   
            $.ajax({
                url: 'http://localhost/wimc/web/checkbox', // '/checkbox' 'http://localhost/wimc/web/checkbox'
                type: 'POST',
                data: data,
                success: function (response) {
                    objectManager.removeAll();
                    objectManager.add(response);
                    console.log(response);
                }
            });
        }
    });
   
    myMap.geoObjects.add(objectManager);
    

  
}