(function () {

    window.points = {
        // Получает данные точек для карты с бэкенда;
        getPoints: function (geoObjects, points, color, captions) {
            for (var i = 0, len = points.length; i < len; i++) {
                if (captions == 1) {
                    geoObjects[i] = new ymaps.Placemark([points[i]['coordinates']['lat'], points[i]['coordinates']['lon']],
                        {
                            iconCaption: points[i]['properties']['iconCaption'],
                            balloonContentHeader: points[i]['properties']['balloonContentHeader'],
                            balloonContentBody: points[i]['properties']['balloonContentBody'],
                            balloonContentFooter: points[i]['properties']['balloonContentFooter'],
                        }, {
                        iconColor: color,
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
                        iconColor: color,
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

        getData: function (data, geoObjects, clusterer, myMap, pointsColors) {
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

                    clusterer.removeAll();

                    if (data['main'] == 1) {
                        window.points.getPoints(geoObjects['main'], window.points.getCustomsList(customsCoords)['main'], pointsColors['main'], data['captions']);
                        clusterer.add(geoObjects['main']);
                    }

                    if (data['head'] == 1) {
                        window.points.getPoints(geoObjects['head'], window.points.getCustomsList(customsCoords)['head'], pointsColors['head'], data['captions']);
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