checkboxes = Array.from(document.querySelectorAll('.customs-checkbox'));
// console.log(checkboxes);
// console.log('ok');

checkboxes.forEach(function(checkbox, i) {

    checkbox.onchange = function() {
        $.ajax({
            url: '/customs/checkbox',
            type: 'POST',
            data: {
                settings: this.name,
                id: this.value,
                checked: this.checked ? 1:0
            },
            beforeSend: function() { checkbox.disabled = true; },
            complete: function() { checkbox.disabled = false; },
            success: function(response) {
                console.log(response);
            }
        });
    }
});