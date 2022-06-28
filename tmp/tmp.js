const yandexMap = document.querySelector('#map');

ymaps.ready(init);

function init() {
    var myMap = new ymaps.Map("map", {
            center: [55.73, 77.75],
            zoom: 3,
            controls: []
        }, {
            searchControlProvider: 'yandex#search'
        }),
        yellowCollection = new ymaps.GeoObjectCollection(null, {
            preset: 'islands#yellowIcon'
        }),
        blueCollection = new ymaps.GeoObjectCollection(null, {
            preset: 'islands#blueIcon'
        });
        // yellowCoords = [[55.73, 37.75], [55.81, 37.75]],
        // blueCoords = [[55.73, 37.65], [55.81, 37.65]];

    // for (var i = 0, l = yellowCoords.length; i < l; i++) {
    //     yellowCollection.add(new ymaps.Placemark(yellowCoords[i]));
    // }
    // for (var i = 0, l = blueCoords.length; i < l; i++) {
    //     blueCollection.add(new ymaps.Placemark(blueCoords[i]));
    // }

    // myMap.geoObjects.add(blueCollection);

    // // Через коллекции можно подписываться на события дочерних элементов.
    // yellowCollection.events.add('click', function () { alert('Кликнули по желтой метке') });
    // blueCollection.events.add('click', function () { alert('Кликнули по синей метке') });

    // // Через коллекции можно задавать опции дочерним элементам.
    // blueCollection.options.set('preset', 'islands#blueDotIcon');


            $.ajax({
            url: 'http://localhost/wimc/web/ajax',
            method: 'get',
            dataType: 'json',
            success: function(data){
             
                // alert(data.text);    /* выведет "Текст" */
                // alert(data.error);   /* выведет "Ошибка" */

                // data.forEach((item) => {
                //     ymaps.geoQuery(ymaps.geocode(item)).addToMap(myMap);
                // });

                for (var i = 0, l = data.length; i < l; i++) {
                    // new ymaps.Placemark([55.694843, 37.435023], {
                    //     balloonContent: 'цвет <strong>носика Гены</strong>',
                    //     iconCaption: 'Очень длиннный, но невероятно интересный текст'
                    // }, {
                    //     preset: 'islands#greenDotIconWithCaption'
                    // })
                    customMark = [data[i]['COORDS_LATITUDE'], data[i]['COORDS_LONGITUDE']];
                    console.log(customMark);

                    // var myPlacemark = new ymaps.Placemark(customMark);

                    var myPlacemark = new ymaps.Placemark(customMark, {
                        balloonContent: data[i]['CODE'] + ' ' + data[i]['NAMT'] + ' ' + data[i]['ADRTAM'],
                        iconCaption: data[i]['CODE'] + ' ' + data[i]['NAMT'],
                        code: data[i]['CODE'],
                    });
                    yellowCollection.add(myPlacemark);
                    
                    // yellowCollection.add(new ymaps.Placemark(customMark));
                }
            }
        });

        myMap.geoObjects.add(yellowCollection);

    
                // Через коллекции можно задавать опции дочерним элементам.
                // yellowCollection.options.set('iconCaption', 'islands#blueDotIcon'); 
                
                // myMap.geoObjects
                // .add(myGeoObject)
                // .add(myPieChart)
                // .add(new ymaps.Placemark(data[0], {
                //     balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
                // }, {
                //     preset: 'islands#icon',
                //     iconColor: '#0095b6'
                // }));

}


    //   var myCollection = new ymaps.GeoObjectCollection();
    //     for (let customType in customsTypes) {
    //         var obj = customsTypes[customType]
    //         for (var i = 0; i < obj.length; i++) {
    //             var row = obj[i];
    //             var coords = row['COORDS'][0] + ',' + row['COORDS'][1];
    //             var myPlacemark = new ymaps.Placemark(coords.split(","), {
    //                 balloonContent: row['CODE'] + ' ' + row['NAMT'] + ' ' + row['ADRTAM'],
    //                 iconCaption: row['CODE'] + ' ' + row['NAMT'],
    //                 code: row['CODE'],
    //             }, {
    //                 preset: 'islands#icon',
    //                 iconColor: '#0000ff',
    //             });
    //             myCollection.add(myPlacemark);
    //         }
    //     }