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

            for (var i = 0, len = points.length; i < len; i++) {
                if (captions == 1) {
                    geoObjects[i] = new ymaps.Placemark([points[i]['coordinates']['lat'], points[i]['coordinates']['lon']],
                        {
                            iconCaption: points[i]['properties']['iconCaption'],
                            balloonContentHeader: points[i]['properties']['balloonContentHeader'],
                            balloonContentBody: points[i]['properties']['balloonContentBody'],
                            balloonContentFooter: points[i]['properties']['balloonContentFooter'],
                        }, {
                        iconColor: pointsColors[points[i]['custom_type']],
                        hideIconOnBalloonOpen: false,
                        balloonOffset: [3, -25],
                    });
                } else {
                    geoObjects[i] = new ymaps.Placemark([points[i]['coordinates']['lat'], points[i]['coordinates']['lon']],
                        {
                            balloonContentHeader: points[i]['properties']['balloonContentHeader'],
                            balloonContentBody: points[i]['properties']['balloonContentBody'],
                            balloonContentFooter: points[i]['properties']['balloonContentFooter'],
                        }, {
                        iconColor: pointsColors[points[i]['custom_type']],
                        hideIconOnBalloonOpen: false,
                        balloonOffset: [3, -25],
                    });
                }

            }
        },

        // Получает список коллекций;
        getCollection: function (myMap, customsParam, collection) {
            if (customsParam) {
                myMap.geoObjects.add(collection);
            } else {
                myMap.geoObjects.remove(collection);
            }
        },

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

        getCustomsList: function (customsCoords) {
            var customsList = {
                'main': [],
                'head': [],
                'excise': [],
                'others': [],
            };

            customsCoords.forEach(function (custom) {
                if (custom['custom_type'] === 'main') {
                    customsList['main'].push(custom);
                }
                if (custom['custom_type'] === 'head') {
                    customsList['head'].push(custom);
                }
                if (custom['custom_type'] === 'excise') {
                    customsList['excise'].push(custom);
                }
                if (custom['custom_type'] === 'others') {
                    customsList['others'].push(custom);
                }
            });

            return customsList;
        },

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

        getData: function (data, geoObjects, clusterer, searchCollection, myMap) {
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

                    window.points.checkAutocomplete(data['autocomplete']);

                    clusterer.removeAll();

                    if (data['main'] == 1) {
                        window.points.getPoints(geoObjects['main'], window.points.getCustomsList(customsCoords)['main'], data['captions']);
                        clusterer.add(geoObjects['main']);
                    }

                    if (data['head'] == 1) {
                        window.points.getPoints(geoObjects['head'], window.points.getCustomsList(customsCoords)['head'], data['captions']);
                        clusterer.add(geoObjects['head']);
                    }

                    if (data['excise'] == 1) {
                        window.points.getPoints(geoObjects['excise'], window.points.getCustomsList(customsCoords)['excise'], data['captions']);
                        clusterer.add(geoObjects['excise']);
                    }

                    if (data['others'] == 1) {
                        window.points.getPoints(geoObjects['others'], window.points.getCustomsList(customsCoords)['others'], data['captions']);
                        clusterer.add(geoObjects['others']);
                    }

                    myMap.geoObjects.add(clusterer);

                    myMap.geoObjects.add(clusterer);
                    myMap.setBounds(clusterer.getBounds(), {
                        checkZoomRange: true
                    });

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
                        }));

                        myMap.geoObjects.add(searchCollection);

                        // Сделаем зум карты до двух точек (точки пользователя и ближайшего к ней поста);
                        myMap.setBounds(searchCollection.getBounds()); 
                        myMap.setZoom(myMap.getZoom()-2); //Чуть-чуть уменьшить зум для красоты
                    }

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