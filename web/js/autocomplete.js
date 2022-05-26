$(function () {

  var searchInputElement = document.querySelector('#searchcustoms-autocomplete');


  searchInputElement.addEventListener('click', evt => {
    var searchListElement = document.querySelector('#ui-id-1');

    if (searchListElement) {
      searchListElement.style.display = 'block';
      // console.log(searchListElement);
      // "width: 1384.41px; top: 153px; left: 406.5px; display: none;
    }

  });

  // Single Select
  $("#searchcustoms-autocomplete").autocomplete({
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
           console.log(data);

        }
      });
    },
    select: function (event, ui) {
      // let geo = ui.item.value;

      $("#latitude").val(ui.item.value[0]);
      $("#longitude").val(ui.item.value[1]);
      $("#searchcustoms-autocomplete").val(ui.item.value[2]);


      // this.value = ui.item.label;


      // console.log(this.value);
      console.log(ui.item.value);





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
      .append("<a>" + item.label + "</a>")
      .appendTo(ul);
  };

});