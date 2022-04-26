// const autoCompleteJS = new autoComplete({
//     data: {
//         src: async query => {
//             try {
//                 const apiUrl = autoCompleteJS.input.dataset.apiUrl;
//                 const source = await fetch(`${apiUrl}/${query}`);
//                 const data = await source.json();
//                 return data;
//             } catch (error) {
//                 return error;
//             }
//         },
//         keys: ['text']
//     },
//     resultItem: {
//         highlight: true
//     },
//     events: {
//         input: {
//             selection: event => {
//                 const selectionValue = event.detail.selection.value;
//                 autoCompleteJS.input.value = selectionValue.text;

//                 const latitudeInputElement = document.querySelector('#latitude');
//                 const longitudeInputElement = document.querySelector('#longitude');
//                 // const cityNameInputElement = document.querySelector('#city_name');
//                 // const addressInputElement = document.querySelector('#address');
                
//                 latitudeInputElement.value = selectionValue.pos[1];
//                 longitudeInputElement.value = selectionValue.pos[0];
//                 // cityNameInputElement.value = selectionValue.city ? selectionValue.city : 0;
//                 // addressInputElement.value = selectionValue.text ? selectionValue.text : 0;
//             }
//         }
//     }
// });

const autoCompleteJS = new autoComplete({
    data: {
        src: async query => {
            try {
                const apiUrl = 'http://localhost/wimc/web/ajaxcities';
                const source = await fetch(`${apiUrl}/${query}`);
                const data = await source.json();
                return data;
            } catch (error) {
                return error;
            }
        },
        keys: ['text']
    },
    resultItem: {
        highlight: true
    },
    events: {
        input: {
            selection: event => {
                const selectionValue = event.detail.selection.value;
                autoCompleteJS.input.value = selectionValue.text;

                const latitudeInputElement = document.querySelector('#latitude');
                const longitudeInputElement = document.querySelector('#longitude');
                // const cityNameInputElement = document.querySelector('#city_name');
                // const addressInputElement = document.querySelector('#address');
                
                latitudeInputElement.value = selectionValue.pos[1];
                longitudeInputElement.value = selectionValue.pos[0];
                // cityNameInputElement.value = selectionValue.city ? selectionValue.city : 0;
                // addressInputElement.value = selectionValue.text ? selectionValue.text : 0;
            }
        }
    }
});