let checkboxes = Array.from(document.querySelectorAll('.customs-checkbox'));

checkboxes.forEach(function(checkbox, i) {

    checkbox.onchange = function() {
        var data = {
                settings: this.id,
                id: this.value,
                checked: this.checked ? 1:0
            };
        $.ajax({
            url: 'http://localhost/wimc/web/checkbox', // '/checkbox'
            type: 'POST',
            data: data,
            beforeSend: function() { checkbox.disabled = true; },
            complete: function() { checkbox.disabled = false; },
            success: function(response) {
                console.log(response);
            }
        });
    }
});