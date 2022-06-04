var bodyWrapper = document.querySelector('.body-wrapper');
var customsList = document.querySelectorAll('.custom-item');
var editList = document.querySelectorAll('.custom-param.edit');
var customEditForm = document.querySelector('.custom-edit');
var customViewForm = document.querySelector('.custom-view');

customsList.forEach(customElement => {
    customElement.addEventListener('click', evt => {

        if (!evt.target.classList.contains('edit-param')) {
            var viewElementId = customElement.querySelector('.id').innerHTML;

            var data = {
                'ID': viewElementId,
            };

            $.ajax({
                url: '/grandmaster/customs',
                //   url: '/web//grandmaster/customs', 
                //   url: 'http://localhost/wimc/web/grandmaster/customs', 
                type: 'POST',
                data: data,
                success: function (response) {
                    customViewForm.style.display = 'block';
                    var customEdit = JSON.parse(response);
                    customViewForm.querySelector('#customeditform-id').value = customEdit['ID'];
                    customViewForm.querySelector('#customeditform-code').value = customEdit['CODE'];
                    customViewForm.querySelector('#customeditform-namt').value = customEdit['NAMT'];
                    customViewForm.querySelector('#customeditform-okpo').value = customEdit['OKPO'];
                    customViewForm.querySelector('#customeditform-ogrn').value = customEdit['OGRN'];
                    customViewForm.querySelector('#customeditform-inn').value = customEdit['INN'];
                    customViewForm.querySelector('#customeditform-name_all').value = customEdit['NAME_ALL'];
                    customViewForm.querySelector('#customeditform-adrtam').value = customEdit['ADRTAM'];
                    customViewForm.querySelector('#customeditform-prosf').value = customEdit['PROSF'];
                    customViewForm.querySelector('#customeditform-telefon').value = customEdit['TELEFON'];
                    customViewForm.querySelector('#customeditform-fax').value = customEdit['FAX'];
                    customViewForm.querySelector('#customeditform-email').value = customEdit['EMAIL'];
                    customViewForm.querySelector('#customeditform-coords_latitude').value = customEdit['COORDS_LATITUDE'];
                    customViewForm.querySelector('#customeditform-coords_longitude').value = customEdit['COORDS_LONGITUDE'];
                }
            });
            var closeBtn = customViewForm.querySelector('.close-btn');
            closeBtn.addEventListener('click', evt => {
                customViewForm.style.display = 'none';
            });

            var cancelButton = customViewForm.querySelector('.cancel-button');

            cancelButton.addEventListener('click', evt => {
                customViewForm.style.display = 'none';
                // console.log('ok');
            });
        }
    });
});

editList.forEach(editElement => {
    editElement.addEventListener('click', evt => {

        var data = {
            'ID': editElement.id
        };

        // Отрисовываю основные таможенные посты;
        $.ajax({
            url: '/grandmaster/customs',
            //   url: '/web//grandmaster/customs', 
            //   url: 'http://localhost/wimc/web/grandmaster/customs', 
            type: 'POST',
            data: data,
            success: function (response) {
                customEditForm.style.display = 'block';
                var customEdit = JSON.parse(response);
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
            }
        });

        var closeBtn = customEditForm.querySelector('.close-btn');
        closeBtn.addEventListener('click', evt => {
            customEditForm.style.display = 'none';
        });

        var cancelButton = customEditForm.querySelector('.cancel-button');

        cancelButton.addEventListener('click', evt => {
            customEditForm.style.display = 'none';
            // console.log('ok');
        });
    });
});