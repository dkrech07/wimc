let checkboxes = Array.from(document.querySelectorAll('.customs-checkbox'));

// console.log(checkboxes);
// console.log('ok');

checkboxes.forEach(function(checkbox, i) {

    checkbox.onchange = function() {
        $.ajax({
            url: 'http://localhost/wimc/web/checkbox/' + checkbox['id'], // '/checkbox'
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


// let checkboxHead = document.querySelector('#head');

// checkboxHead.onchange = function() {
//         $.ajax({
//             url: 'http://localhost/wimc/web/checkbox/head', //'/customs/checkbox'
//             type: 'POST',
//             data: {
//                 settings: this.name,
//                 id: this.value,
//                 checked: this.checked ? 1:0
//             },
//             beforeSend: function() { checkboxHead.disabled = true; },
//             complete: function() { checkboxHead.disabled = false; },
//             success: function(response) {
//                 console.log(response);
//             }
//         });
//     }