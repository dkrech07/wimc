function checkClusterPoints() {
    // определяю событие клика на кластере
  clusterer.events.add('click', function (e) {
      // получаем ссылку на объект, по которому кликнули
      // console.log(e);
      var cluster = e.get('target');//.state.get('activeObject')

      if (cluster.options._name == 'cluster') {
          var clusterPoints = cluster.getGeoObjects();
          var pointsCoordinates = [];
          clusterPoints.forEach(point => {
              pointsCoordinates.push(point.geometry._coordinates);
          });

          pointsCoordinates.forEach(point => {
              currentPoint = point;

          });

          var check = true;
          for(var i = 0; i < pointsCoordinates.length; i++){
              currentPoint = pointsCoordinates[i];
              for(var j = 0; j < pointsCoordinates.length; j++){
                  checkPoint = pointsCoordinates[j];
                  if (currentPoint[0] == checkPoint[0] && currentPoint[1] == checkPoint[1]) {
                      currentPoint = checkPoint;
                     
                  } else {
                      console.log('онаружены расхождения в координатах');
                      // console.log(checkPoint);
                      // console.log(currentPoint);
                      // clusterer.options.set({
                      //     clusterOpenBalloonOnClick: false,
                      //     clusterDisableClickZoom: false
                      // });
                      return;
                  } 
              }
          }
          // console.log(pointsCoordinates);
          console.log('расхождений не обнаружено');
          console.log(currentPoint);

          // clusterer.options.set({
          //     clusterDisableClickZoom: true
          // });

          // myMap.setBounds(clusterer.getBounds(), {
          //     checkZoomRange: true
          // });

          // clusterer.options.set({
          //     disableClickZoom: true,
          //     // clusterOpenBalloonOnClick: true,
          //     // clusterDisableClickZoom: true
          // });

          // return;
  

          // cluster.balloon.open();
          // clusterer.options.set('disableClickZoom', true)
          // clusterer.getBounds(),

          // zoomOutButtonElement.addEventListener('click', (evt)=>{
          //     myMap.setCenter([57.76, 77.64]);
          //     myMap.setBounds(clusterer.getBounds()); 
          // });

          myMap.setBounds(cluster.getBounds(), {
              checkZoomRange: true
          });

          clusterer.balloon.open(cluster);
          
      }


      // console.log(pointsCoordinates);



      // // включаем монитор слежения по переключению clusterCaption в балуне кластера
      // var stateMonitor = new ymaps.Monitor(cluster.state);
      // stateMonitor.add('activeObject', function(activeObject) {
      //     console.log(activeObject);
      //     // любые действия по выбранной метке кластера
      // });
  
  });  
}
checkClusterPoints();