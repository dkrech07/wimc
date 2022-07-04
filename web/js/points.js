(function () {

    window.points = {
        // Получает данные точек для карты с бэкенда;
        getPoints: function (geoObjects, points, captions) {
            // Карта цветов меток;
            var pointsColors = {
                'main': '#00AA00',
                'head': '#FF0000',
                'excise': '#0000FF',
                'others': '#E8B000',
            };

            // getPointType

            for (var i = 0, len = points.length; i < len; i++) {
                if (captions == 1) {
                    geoObjects[points[i]['point_type']].push(new ymaps.Placemark([points[i]['latitude'], points[i]['longitude']],
                        {
                            iconCaption: points[i]['code'] + ' ' + points[i]['namt'],
                            balloonContentHeader: "<div class=ballon_header style='font-size: 12px;'>" + points[i]['code'] + " " + points[i]['namt'] + "</div>",
                            balloonContentBody: '<div class=ballon_body>' + points[i]['adrtam'] + '</div>',
                            balloonContentFooter: "<div class='ballon_footer'>" + points[i]['telefon'] + "</div>" + "<div class='ballon_footer'>" + points[i]['email'] + "</div>",
                        }, {
                        iconColor: pointsColors[points[i]['custom_type']],
                        hideIconOnBalloonOpen: false,
                        balloonOffset: [3, -25],
                    }));
                } else {
                    geoObjects[points[i]['point_type']].push(new ymaps.Placemark([points[i]['latitude'], points[i]['longitude']],
                        {
                            balloonContentHeader: "<div class=ballon_header style='font-size: 12px;'>" + points[i]['code'] + " " + points[i]['namt'] + "</div>",
                            balloonContentBody: '<div class=ballon_body>' + points[i]['adrtam'] + '</div>',
                            balloonContentFooter: "<div class='ballon_footer'>" + points[i]['telefon'] + "</div>" + "<div class='ballon_footer'>" + points[i]['email'] + "</div>",
                        }, {
                        iconColor: pointsColors[points[i]['custom_type']],
                        hideIconOnBalloonOpen: false,
                        balloonOffset: [3, -25],
                    }));
                }

            }
        },

        // Получает список коллекций;
        // getCollection: function (myMap, customsParam, collection) {
        //     if (customsParam) {
        //         myMap.geoObjects.add(collection);
        //     } else {
        //         myMap.geoObjects.remove(collection);
        //     }
        // },

        checkClusterPoints: function (myMap, clusterer) {
            clusterer.events.add('click', function (e) {
                // получаем ссылку на объект, по которому кликнули
                var cluster = e.get('target');
                if (cluster.options._name == 'cluster') {
                    var clusterPoints = cluster.getGeoObjects();

                    var pointsCoordinates = []; // список всех точек координат кластера;
                    clusterPoints.forEach(point => {
                        pointsCoordinates.push(point.geometry._coordinates);
                    });

                    for (var i = 0; i < pointsCoordinates.length; i++) {
                        currentPoint = pointsCoordinates[i];
                        for (var j = 0; j < pointsCoordinates.length; j++) {
                            checkPoint = pointsCoordinates[j];

                            if (currentPoint[0] != checkPoint[0] || currentPoint[1] != checkPoint[1]) {
                                myMap.setCenter(pointsCoordinates[0]);
                                myMap.setBounds(cluster.getBounds());
                                return;
                            }
                        }
                    }
                    clusterer.balloon.open(cluster);

                }
            });
        },

        zoomOut: function (myMap, clusterer) {
            var zoomOutButtonElement = document.querySelector('.zoom-out');

            zoomOutButtonElement.addEventListener('click', (evt) => {
                myMap.setCenter([57.76, 77.64]);
                myMap.setBounds(clusterer.getBounds());
            });
        },

        // getCustomsList: function (customsCoords) {
        //     var customsList = {
        //         'main': [],
        //         'head': [],
        //         'excise': [],
        //         'others': [],
        //     };

        //     customsCoords.forEach(function (custom) {
        //         if (custom['custom_type'] === 'main') {
        //             customsList['main'].push(custom);
        //         }
        //         if (custom['custom_type'] === 'head') {
        //             customsList['head'].push(custom);
        //         }
        //         if (custom['custom_type'] === 'excise') {
        //             customsList['excise'].push(custom);
        //         }
        //         if (custom['custom_type'] === 'others') {
        //             customsList['others'].push(custom);
        //         }
        //     });

        //     return customsList;
        // },

        checkAutocomplete: function (data) {
            var searchInputElement = document.querySelector('#autocomplete');

            if (!data) {
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
        },

        getNearestInfo: function (item) {
            var nearestItem = document.createElement('li');
            nearestItem.className = 'nearest-item';

            var nearestItemDistance = document.createElement('span');
            nearestItemDistance.className = 'nearest-distance';
            // nearestItemDistance.textContent = '~' + Math.floor(item['distance']) + ' км';
            var number = item['distance'];
            nearestItemDistance.textContent = '~' + (Math.floor(number * 100) / 100) + ' км';


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
        },

        getData: function (data, clusterer, searchCollection, myMap) {
            $.ajax({
                url: '/checkbox',
                type: 'POST',
                data: data,
                success: function (response) {
                    let customsCoords = JSON.parse(response);

                    console.log('data:');
                    console.log(data);
                    console.log('response:');
                    console.log(customsCoords);

                    geoObjects = {
                        'points': [],
                        'nearest': [],
                    };

                    // console.log(geoObjects);

                    window.points.checkAutocomplete(data['autocomplete']);

                    clusterer.removeAll();

                    window.points.getPoints(geoObjects, customsCoords, data['captions']);


                    clusterer.add(geoObjects['points']);
                    myMap.geoObjects.add(clusterer);

                    if (data['latitude'] && data['longitude']) {
                        searchCollection.removeAll();

                        searchCollection.add(new ymaps.Placemark([data['latitude'], data['longitude']], {
                            balloonContentHeader: 'Вы искали:',
                            balloonContentBody: data['autocomplete'],
                            balloonContentFooter: 'Координаты точки: ' + data['latitude'] + ', ' + data['longitude'],
                            iconCaption: 'Ваша точка',
                        }, {
                            preset: 'islands#pinkDotIcon',
                            iconColor: 'red',
                            hideIconOnBalloonOpen: false,
                            balloonOffset: [3, -25],
                        }));

                        
                        // var squareLayout = ymaps.templateLayoutFactory.createClass('<div class="placemark_layout_container"><div class="square_layout">$</div></div>');
                        // geoObjects['nearest'][0].squareLayout = squareLayout;

                        searchCollection.add(geoObjects['nearest'][0]);
                        searchCollection.add(geoObjects['nearest'][1]);
                        searchCollection.add(geoObjects['nearest'][2]);

                        myMap.geoObjects.add(searchCollection);

                        // Сделаем зум карты до двух точек (точки пользователя и ближайшего к ней поста);
                        myMap.setBounds(searchCollection.getBounds());
                        // myMap.setZoom(myMap.getZoom()-2); //Чуть-чуть уменьшить зум для красоты

                        var nearestPopupElement = document.querySelector('.nearest-popup');

                        var nearestContainerElement = nearestPopupElement.querySelector('.nearest-list');
                        var otherContainerElement = nearestPopupElement.querySelector('.nearest-others');

                        if (nearestPopupElement.classList.contains('nearest-active')) {
                            var nearestLists = nearestPopupElement.querySelectorAll('.nearest-list');
                            while (nearestLists[0].firstChild) {
                                nearestLists[0].removeChild(nearestLists[0].firstChild);
                            }
                            while (nearestLists[1].firstChild) {
                                nearestLists[1].removeChild(nearestLists[1].firstChild);
                            }
                        } else {
                            nearestPopupElement.classList.remove('nearest-disabled');
                            nearestPopupElement.classList.add('nearest-active');
                        }

                        if (nearestPopupElement.classList.contains('roll-down')) {
                            var nearestTitles = nearestPopupElement.querySelectorAll('.nearest-title');
                            var nearestLists = nearestPopupElement.querySelectorAll('.nearest-list');
                            var rollButtonElement = nearestPopupElement.querySelector('.roll-button');

                            nearestPopupElement.classList.remove('roll-down');
                            nearestPopupElement.classList.add('roll-up');

                            rollButtonElement.textContent = 'Развернуть';

                            nearestTitles.forEach(function (element) {
                                element.style.display = 'block';
                            });

                            nearestLists.forEach(function (element) {
                                element.style.display = 'block';
                            });
                        }

                        nearestContainerElement.append(window.points.getNearestInfo(customsCoords[0]));
                        otherContainerElement.append(window.points.getNearestInfo(customsCoords[1]));
                        otherContainerElement.append(window.points.getNearestInfo(customsCoords[2]));

                        // nearestContainerElement.style.backgroundColor = '#D9D9D9';

                        var nearestItemElement = nearestPopupElement.querySelectorAll('.nearest-item');

                        nearestItemElement.forEach((element, index) => {
                
                            element.addEventListener('click', evt => {

                                nearestItemElement.forEach(element => {
                                    element.style.backgroundColor = '#FFFFFF';
                                });

                                element.style.backgroundColor = '#D9D9D9';

                                geoObjects['nearest'][index].balloon.open(myMap.getCenter());
                            });
                        });
                    }



                    // myMap.setBounds(clusterer.getBounds(), {
                    //     checkZoomRange: true
                    // });

                    // if (data['main'] == 1) {
                    //     window.points.getPoints(geoObjects, customsCoords, data['captions']);
                    // }

                    // if (data['head'] == 1) {
                    //     window.points.getPoints(geoObjects, customsCoords, data['captions']);
                    //     // clusterer.add(geoObjects['head']);
                    // }

                    // if (data['excise'] == 1) {
                    //     window.points.getPoints(geoObjects, customsCoords, data['captions']);
                    //     // clusterer.add(geoObjects['excise']);
                    // }

                    // if (data['others'] == 1) {
                    //     window.points.getPoints(geoObjects, customsCoords, data['captions']);
                    //     // clusterer.add(geoObjects['others']);
                    // }


                    // myMap.geoObjects.add(clusterer);





                    // myMap.geoObjects.add(searchCollection);

                    //!!!!!!!!!!!!!!!!!!!!!!! ЗДЕСЬ РИСУЕТСЯ ТОЧКА НА КАРТЕ;
                    // searchCollection.add(new ymaps.Placemark([searchData['nearest_lat'], searchData['nearest_lon']]));

                    //!!!!!!!!!!!!!!!!!!!!!!! ЗДЕСЬ ВЫПОЛНЯЕТСЯ ЗУМ К ТОЧКЕ ПОЛЬЗОВАТЕЛИ НАЙДЕННОМУ БЛИЖАЙШЕМУ ПОСТУ;
                    // Сделаем зум карты до двух точек (точки пользователя и ближайшего к ней поста);
                    // myMap.setBounds(searchCollection.getBounds()); 
                    // myMap.setZoom(myMap.getZoom()-2); //Чуть-чуть уменьшить зум для красоты


                    // if (data[checkbox.id] == 1 && checkbox.id !== 'captions') {

                    //     window.points.getPoints(geoObjects[checkbox.id], customsCoords[checkbox.id], pointsColors[checkbox.id], data['captions']);

                    //     clusterer.add(geoObjects[checkbox.id]);
                    //     myMap.geoObjects.add(clusterer);
                    // } else if (checkbox.id == 'captions') {

                    // } else {
                    //     clusterer.remove(geoObjects[checkbox.id]);
                    // }
                }
            });
        }

    };


})();