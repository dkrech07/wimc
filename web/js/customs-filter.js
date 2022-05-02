let checkboxes = Array.from(document.querySelectorAll('.customs-checkbox'));

var data = {};
checkboxes.forEach(function(checkbox, i) {

    checkbox.onchange = function() {

        checkboxes.forEach(function(checkbox){
            data[checkbox.id] = 
                // settings: checkbox.id,
                // id: checkbox.value,
               checkbox.checked ? 1:0;
        });

  
        $.ajax({
            url: 'http://localhost/wimc/web/checkbox', // '/checkbox'
            type: 'POST',
            data: data,
            // beforeSend: function() { checkbox.disabled = true; },
            // complete: function() { checkbox.disabled = false; },
            success: function(response) {
                console.log(response);
            }
        });
    }
});



