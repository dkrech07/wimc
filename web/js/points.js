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
 
    };


})();