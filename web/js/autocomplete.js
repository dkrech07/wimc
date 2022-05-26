$(function () {

  var searchFlag;

  var searchInputElement = document.querySelector('#autocomplete');
  var clearBtnElement = document.querySelector('.clear-btn');

  console.log(searchInputElement.offsetWidth);
  // clearBtnElement.style.display = 'block';

  clearBtnElement.addEventListener('click', evt => {
    searchInputElement.value = '';
    var searchListElement = document.querySelector('#ui-id-1');

    if (searchListElement) {
      searchListElement.style.display = 'none';
    }

    clearBtnElement.style.display = 'none';  
  });

  searchInputElement.addEventListener('click', evt => {
    var searchListElement = document.querySelector('#ui-id-1');

    searchListElement.style.width = searchInputElement.offsetWidth + 'px';
    console.log(searchListElement.offsetWidth);
    console.log(searchListElement.style.width);

    if (searchListElement && searchInputElement.value) {
      // searchListElement.style.width = searchInputElement.offsetWidth;
      // searchListElement.offsetWidth = searchInputElement.offsetWidth;

      searchListElement.style.display = 'block';
    }
  });

  searchInputElement.addEventListener('input', evt => {
   
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

          response($.map(data, function (geo) {
            return {
              label: geo.display_name['formatted'],
              value: [geo.lat, geo.lon, geo.display_name['clean']]
            };
          }));
          //    response(data);
          //  console.log(data);
          var searchListElement = document.querySelector('#ui-id-1');
          searchListElement.style.width = searchInputElement.offsetWidth + 'px';
        }
      });
    },
    select: function (event, ui) {
      // let geo = ui.item.value;

      $("#latitude").val(ui.item.value[0]);
      $("#longitude").val(ui.item.value[1]);
      $("#autocomplete").val(ui.item.value[2]);


      // this.value = ui.item.label;


      // console.log(this.value);
      // console.log(ui.item.value);





      event.preventDefault();



      //  // Set selection
      //  $('#autocomplete').val(ui.item.label); // display the selected text
      //  $('#selectuser_id').val(ui.item.value); // save selected id to input
      //  return false;
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