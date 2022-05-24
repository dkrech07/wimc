$(function() {

// Single Select
 $("#autocomplete").autocomplete({
    source: function(request, response) {

     // Fetch data
     $.ajax({
      url: "http://localhost/wimc/web/autocomplete",
    //   type: 'post',
      dataType: "json",
      data: {
        term: request.term
      },
      success: function(data) {
    
        response($.map(data, function (geo) {
            return {                                
                label: geo.display_name,
                value: [geo.lat, geo.lon]
            };
        }));
    //    response(data);
       console.log(data);

      }
     });
    },
    // select: function (event, ui) {
    //    // Set selection
    //    $('#autocomplete').val(ui.item.label); // display the selected text
    //    $('#selectuser_id').val(ui.item.value); // save selected id to input
    //    return false;
    // },
    // focus: function(event, ui){
    //    $("#autocomplete").val(ui.item.label);
    //    $("#selectuser_id").val(ui.item.value);
    //    return false;
    //  },
   }).data("ui-autocomplete")._renderItem = function (ul, item) {
    return $("<li></li>")
        .data("item.autocomplete", item)
        .append("<a>" + item.label + "</a>")
        .appendTo(ul);
};

});