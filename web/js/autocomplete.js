$(function () {

  var searchFlag;
  const LIST_PADDING = 12;

  var searchInputElement = document.querySelector('#autocomplete');
  var searchBtn = document.querySelector('.search-btn');

  var latitudeInputElement = document.querySelector('#latitude');
  var longitudeInputElement = document.querySelector('#longitude');

  var clearBtnElement = document.querySelector('.clear-btn');

  clearBtnElement.addEventListener('click', evt => {
    searchInputElement.value = '';
    var searchListElement = document.querySelector('#ui-id-1');

    if (searchListElement) {
      searchListElement.style.display = 'none';
    }

    clearBtnElement.style.display = 'none';
  });

  // searchInputElement.addEventListener('focus', evt => {
    // searchBtn.style.boxShadow = 'none';
    // console.log('boxShadow = none');
  // });

  $('#autocomplete').on('focus', function() {
    searchBtn.style.boxShadow = 'none';

    var searchListElement = document.querySelector('#ui-id-1');
    searchListElement.style.width = searchInputElement.offsetWidth + 'px';
    if (searchListElement && searchInputElement.value) {
      searchListElement.style.display = 'block';
    }
  });

  // $('#autocomplete').on('blur', function() {
  //   searchBtn.style.boxShadow = '4px 4px 4px rgb(109, 106, 104)';
  // });

  // searchInputElement.addEventListener('click', evt => {
  //   var searchListElement = document.querySelector('#ui-id-1');
  //   searchListElement.style.width = searchInputElement.offsetWidth + 'px';
  //   if (searchListElement && searchInputElement.value) {
  //     searchListElement.style.display = 'block';
  //   }
  // });

  searchInputElement.addEventListener('input', evt => {

    latitudeInputElement.value = null;
    longitudeInputElement.value = null;

    if (searchInputElement.value == '') {
      clearBtnElement.style.display = 'none';
    } else if (searchInputElement.value) {
      clearBtnElement.style.display = 'block';
    }

  });

  // Single Select
  $("#autocomplete").autocomplete({
    source: function (request, response) {

      // Fetch data
      $.ajax({
        url: "http://localhost/wimc/web/autocomplete", // 'http://localhost/wimc/web/autocomplete' /autocomplete
        //   type: 'post',
        dataType: "json",
        data: {
          term: request.term
        },
        success: function (data) {
          if (!data.length) {
            var result = [
              {
                label: '<i style="color: #6c757d">Ничего не нашлось... Попробуйте изменить или дополнить запрос</i>',
                value: [null, null, null]
              }
              // { label: 'По запросу ' + '<b>' + request.term + '</b>' + ' не найдено результатов', value: ''}
            ];

            response(result);

            console.log(result);

          } else {
            response($.map(data, function (geo) {
              console.log(data);

              return {
                label: geo.display_name['formatted'],
                value: [geo.lat, geo.lon, geo.display_name['clean']]
              };
            }));
          }

          var searchListElement = document.querySelector('#ui-id-1');
          searchListElement.style.width = searchInputElement.offsetWidth + 'px';
          searchListElement.style.top = $('#autocomplete').offset()['top'] + 36 + 'px';
          searchListElement.style.left = '50%';
          searchListElement.style.marginLeft = -searchInputElement.offsetWidth / 2 + 'px';

          console.log($('#ui-id-1').offset()['top']);
          console.log($('#autocomplete').offset()['top']);

          // var searchElements = searchListElement.querySelectorAll('.ui-menu-item');
          // searchElements.forEach(element => {
          //   element.addEventListener('mouseover', evt => {
          //     element.classList.forEach(item => {

          //       if (item == 'ui-state-active') {
          //         element.classList.remove('ui-state-active');
          //       } else {
          //         element.classList.add('ui-state-active');
          //       }

          //     });

          //   });
          // });
        }
      });
    },
    minLength: 3,
    select: function (event, ui) {

      if (ui.item.value[2]) {
        $("#latitude").val(ui.item.value[0]);
        $("#longitude").val(ui.item.value[1]);
        $("#autocomplete").val(ui.item.value[2]);
      }

      // console.log(ui.item.value);
      event.preventDefault();
    },
    // focus: function(event, ui){
    //   // console.log(ui);
    //   //  $("#autocomplete").val(ui.item.label);
    //   //  $("#selectuser_id").val(ui.item.value);
    //   //  return false;
    //  },
  }).data("ui-autocomplete")._renderItem = function (ul, item) {

    return $("<li></li>")
      .data("item.autocomplete", item)
      .append("<span>" + item.label + "</span>")
      .appendTo(ul);
  };

});