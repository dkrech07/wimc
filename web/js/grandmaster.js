var bodyWrapper = document.querySelector('.body-wrapper');
var customsList = document.querySelectorAll('.custom-item');
var editList = document.querySelectorAll('.custom-param.edit');
var customEditForm = document.querySelector('.custom-edit');
var customViewForm = document.querySelector('.custom-view');
var customNewForm = document.querySelector('.custom-new');
var customDeleteButton = document.querySelector('.delete-button');
var deleteWindow = document.querySelector('.delete-window');
var addNewCustom = document.querySelector('.add-new-custom');

customsList.forEach(customElement => {
    customElement.addEventListener('click', evt => {

        if (!evt.target.classList.contains('edit-param')) {
            var viewElementId = customElement.querySelector('.id').innerHTML;

            var data = {
                'CUSTOM_ID': viewElementId,
            };

            $.ajax({
                url: '/grandmaster/customs',
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
            'CUSTOM_ID': editElement.id
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

customDeleteButton.addEventListener('click', evt => {
    var customDeleteId = customEditForm.querySelector('#customeditform-id').value;

    if (customDeleteId) {
        deleteWindow.style.display='block';
        var deletePostId = deleteWindow.querySelector('.delete-post-id');
        deletePostId.textContent = customDeleteId;

        var noButton = deleteWindow.querySelector('.custom-delete-no');
        var yesButton = deleteWindow.querySelector('.custom-delete-yes');

        noButton.addEventListener('click', evt => {
            deleteWindow.style.display='none';
        });

        yesButton.addEventListener('click', evt => {
            var data = {
                'CUSTOM_DELETE': customDeleteId
            };

            $.ajax({
                url: '/grandmaster/customs',
                type: 'POST',
                data: data
            });
        });

    }
});

addNewCustom.addEventListener('click', evt=> {
    customNewForm.style.display = 'block';

    var closeBtn = customNewForm.querySelector('.close-btn');
    closeBtn.addEventListener('click', evt => {
        customNewForm.style.display = 'none';
    });

    var cancelButton = customNewForm.querySelector('.cancel-button');

    cancelButton.addEventListener('click', evt => {
        customNewForm.style.display = 'none';
    });
});

$(document).ready(function () {

    var start_pos = $('.customs-menu').offset().top;
    var start_pos = $('.pagination-list').offset().top;
    var start_pos = $('.edit-buttons').offset().top;
    var start_pos = $('.custom-search').offset().top;

    $(window).scroll(function () {
        if ($(window).scrollTop() >= start_pos) {
            if ($('.customs-menu').hasClass() == false) $('.customs-menu').addClass('customs-menu-fixed');
            if ($('.pagination-list').hasClass() == false) $('.pagination-list').addClass('pagination-list-fixed');
            if ($('.edit-buttons').hasClass() == false) $('.edit-buttons').addClass('edit-buttons-fixed');
            if ($('.custom-search').hasClass() == false) $('.custom-search').addClass('custom-search-fixed');

        }
        else {
            $('.customs-menu').removeClass('customs-menu-fixed');
            $('.pagination-list').removeClass('pagination-list-fixed');
            $('.edit-buttons').removeClass('edit-buttons-fixed');
            $('.custom-search').removeClass('custom-search-fixed');
        }

    });

});

















// var allCustomsBtn = document.querySelector('.all-customs-button');
// var addNewCustomBtn = document.querySelector('.add-new-custom-button');

// allCustomsBtn.addEventListener('click', evt => {
//     var data = {
//         'allCustomsBtn': 1
//     };

//     $.ajax({
//         url: '/grandmaster/customs',
//         //   url: '/web//grandmaster/customs',
//         //   url: 'http://localhost/wimc/web/grandmaster/customs',
//         type: 'POST',
//         data: data,
//         success: function (response) {
//             console.log(response);
//             // let customsCoords = JSON.parse(response);

//         }
//     });
// });

// var customsSearchForm = document.querySelector('#custom-edit');
// var customsSearchButton = customsSearchForm.querySelector('.custom-search-button');

// customsSearchButton.addEventListener('click', evt => {
//     evt.preventDefault();

//     var searchCodeInputElement = customsSearchForm.querySelector('#customsearchform-code');
//     var searchNameInputElement = customsSearchForm.querySelector('#customsearchform-namt');

//     var data = {
//         'CODE': searchCodeInputElement.value,
//         'NAMT': searchNameInputElement.value,
//     }

//     $.ajax({
//         url: '/grandmaster/customs',
//         //   url: '/web//grandmaster/customs',
//         //   url: 'http://localhost/wimc/web/grandmaster/customs',
//         type: 'POST',
//         data: data,
//         success: function (response) {
//             console.log(response);
//             // let customsCoords = JSON.parse(response);

//         }
//     });
// });
// $(document).ready(function() {
// var start_pos=$('.stick_menu').offset().top;
//  $(window).scroll(function(){
//   if ($(window).scrollTop()>=start_pos) {
//         if ($('.relative_menu').hasClass()==false) $('.relative_menu').removeClass('relative');
//       if ($('.stick_menu').hasClass()==false) $('.stick_menu').addClass('fixed');
//   }
//   else $('.stick_menu').removeClass('fixed');
//  });
// });