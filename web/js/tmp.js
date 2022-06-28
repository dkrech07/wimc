// Start

if (yandexMap) {















   // Отрисовывает точки при поиске обеъкта на карте;
   $('#search-customs').on('beforeSubmit', function(){
        data['autocomplete'] = this['SearchCustoms[autocomplete]'].value;
        data['latitude'] = this['SearchCustoms[latitude]'].value;
        data['longitude'] = this['SearchCustoms[longitude]'].value;
        // data['nearest_lat'] = this['SearchCustoms[nearest_lat]'].value;
        // data['nearest_lon'] = this['SearchCustoms[nearest_lon]'].value;
        // data['distance'] = this['SearchCustoms[distance]'].value;

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

            //!!!!!!!!!!!!!!!!!!!!!!! ЗДЕСЬ РИСУЕТСЯ ТОЧКА НА КАРТЕ;
            searchCollection.add(new ymaps.Placemark([searchData['nearest_lat'], searchData['nearest_lon']]));
            myMap.geoObjects.add(searchCollection);

            //!!!!!!!!!!!!!!!!!!!!!!! ЗДЕСЬ ВЫПОЛНЯЕТСЯ ЗУМ К ТОЧКЕ ПОЛЬЗОВАТЕЛИ НАЙДЕННОМУ БЛИЖАЙШЕМУ ПОСТУ;
            // Сделаем зум карты до двух точек (точки пользователя и ближайшего к ней поста);
            // myMap.setBounds(searchCollection.getBounds()); 
            // myMap.setZoom(myMap.getZoom()-2); //Чуть-чуть уменьшить зум для красоты
           
            function getNearestInfo (item) {
                var nearestItem = document.createElement('li');
                nearestItem.className = 'nearest-item';

                var nearestItemDistance = document.createElement('span');
                nearestItemDistance.className = 'nearest-distance';
                nearestItemDistance.textContent = '~' + Math.floor(item['distance'] * 100000) + ' км';

                var nearestItemName = document.createElement('span');
                nearestItemName.className = 'nearest-name';
                nearestItemName.textContent = item['namt'];

                var nearestItemAddress = document.createElement('span');
                nearestItemAddress.className = 'nearest-address';
                nearestItemAddress.textContent = item['adrtam'];

                nearestItem.append(nearestItemDistance);
                nearestItem.append(nearestItemName);
                nearestItem.append(nearestItemAddress);

                return nearestItem;
            }

            var nearestPopupElement = document.querySelector('.nearest-popup');
         
            // console.log(nearestPopupElement.classList);

            if (nearestPopupElement.classList.contains('nearest-active')) {
                var nearestLists = nearestPopupElement.querySelectorAll('.nearest-list');

                while (nearestLists[0].firstChild) {
                    nearestLists[0].removeChild(nearestLists[0].firstChild);
                }
    
                while (nearestLists[1].firstChild) {
                    nearestLists[1].removeChild(nearestLists[1].firstChild);
                }

                // nearestPopupElement.classList.remove('nearest-active');
                // nearestPopupElement.classList.add('nearest-disabled');
            } else {
                nearestPopupElement.classList.remove('nearest-disabled');
                nearestPopupElement.classList.add('nearest-active');
            }

            var nearestContainerElement = nearestPopupElement.querySelector('.nearest-list');
            var otherContainerElement = nearestPopupElement.querySelector('.nearest-others');

            nearestContainerElement.append(getNearestInfo(searchData['nearest_points'][0]));
            otherContainerElement.append(getNearestInfo(searchData['nearest_points'][1]));
            otherContainerElement.append(getNearestInfo(searchData['nearest_points'][2]));
        },
            // error: function(){
            //     alert('Error!');
            // }
        });
        return false;
    });


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

//!!!!!!!!!!!!!!!!!!!!!!! ЗДЕСЬ РИСУЕТСЯ ТОЧКА НА КАРТЕ;
searchCollection.add(new ymaps.Placemark([searchData['nearest_lat'], searchData['nearest_lon']]));
myMap.geoObjects.add(searchCollection);