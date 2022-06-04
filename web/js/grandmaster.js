var bodyWrapper = document.querySelector('.body-wrapper');
var customsList = document.querySelectorAll('.custom-item');
var editList = document.querySelectorAll('.custom-param.edit');
var customEditForm = document.querySelector('.custom-edit');

customsList.forEach(customElement => {
    customElement.addEventListener('click', evt => {
        // console.log('ok');
    });
});

editList.forEach(editElement => {
    editElement.addEventListener('click', evt => {

        var data = {
            'ID': editElement.id
        };

        // $.ajax({
        //     url: '/grandmaster/customs',
        //     type: 'post',
        //     dataType: 'json',
        //     data: data,
        // });

        // Отрисовываю основные таможенные посты;
        $.ajax({
            url: '/grandmaster/customs',
            //   url: '/web//grandmaster/customs', 
            //   url: 'http://localhost/wimc/web/grandmaster/customs', 
            type: 'POST',
            data: data,
            success: function (response) {
                customEditForm.style.display = 'block';

                let customEdit = JSON.parse(response);
                // var customEditFormInputList = customEditForm.querySelectorAll('input');

                customEditForm.querySelector('#customeditform-id').value = customEdit['ID'];
                customEditForm.querySelector('#customeditform-code').value = customEdit['CODE'];
                customEditForm.querySelector('#customeditform-namt').value = customEdit['NAMT'];
                customEditForm.querySelector('#customeditform-okpo').value = customEdit['OKPO'];
                customEditForm.querySelector('#customeditform-ogrn').value = customEdit['OGRN'];
                customEditForm.querySelector('#customeditform-inn').value = customEdit['INN'];
                customEditForm.querySelector('#customeditform-name_all').value = customEdit['NAME_ALL'];
                customEditForm.querySelector('#customeditform-adrtam').value = customEdit['ADRTAM'];
                customEditForm.querySelector('#customeditform-prosf').value = customEdit['PROSF'];
                customEditForm.querySelector('#customeditform-telefon').value = customEdit['TELEFON'];
                customEditForm.querySelector('#customeditform-fax').value = customEdit['FAX'];
                customEditForm.querySelector('#customeditform-email').value = customEdit['EMAIL'];
                customEditForm.querySelector('#customeditform-coords_latitude').value = customEdit['COORDS_LATITUDE'];
                customEditForm.querySelector('#customeditform-coords_longitude').value = customEdit['COORDS_LONGITUDE'];

                // console.log(customEditForm.querySelector('#customeditform-code'));

                // getPoints(geoObjects['main'], customsCoords['main'], pointsColors['main'], data['captions']);
                // clusterer.add(geoObjects['main']);
                // myMap.geoObjects.add(clusterer);
                // console.log(myMap.geoObjects);
                // myMap.setBounds(clusterer.getBounds(), {
                //     checkZoomRange: true
                // });

                // getPoints(geoObjects['main'], customsCoords['main'], pointsColors['main'], data['captions']);
                // clusterer.add(geoObjects['main']);
                // myMap.geoObjects.add(clusterer);
                // console.log(myMap.geoObjects);
                // myMap.setBounds(clusterer.getBounds(), {
                //     checkZoomRange: true
                // });
            }
        });

        var closeBtn = customEditForm.querySelector('.close-btn');
        closeBtn.addEventListener('click', evt => {
            customEditForm.style.display = 'none';
        });
    });
});