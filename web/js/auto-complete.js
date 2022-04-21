const autoCompleteJS = new autoComplete({ 
// API Advanced Configuration Object

    selector: "#autoComplete",
    placeHolder: "Введите название адрес и мы найдем таможни рядом!",

    data: {
        src: async query => {
            try {
                const apiUrl = autoCompleteJS.input.dataset.apiUrl;
                const source = await fetch(`${apiUrl}/${query}`);
                const data = await source.json();
                console.log(data);
                return data;
            } catch (error) {
                return error;
            }
        },
        keys: ['display_name']
    },
    // resultsList: {
    //     maxResults: 20,
    //     threshold: 3,
    // },
    resultItem: {
        highlight: true,
    },
    events: {
        input: {
            selection: event => {
                const selectionValue = event.detail.selection.value;
                autoCompleteJS.input.value = selectionValue.display_name;

                const latitudeInputElement = document.querySelector('#latitude');
                const longitudeInputElement = document.querySelector('#longitude');
                // const cityNameInputElement = document.querySelector('#city_name');
                // const addressInputElement = document.querySelector('#address');
                
                latitudeInputElement.value = selectionValue.lat;
                longitudeInputElement.value = selectionValue.lon;
                // cityNameInputElement.value = selectionValue.city ? selectionValue.city : 0;
                // addressInputElement.value = selectionValue.text ? selectionValue.text : 0;
            }
        }
    }

    // data: {
    //     src: ["Sauce - Thousand Island", "Wild Boar - Tenderloin", "Goat - Whole Cut"],
    //     cache: true,
    // },
    // resultsList: {
    //     element: (list, data) => {
    //         if (!data.results.length) {
    //             // Create "No Results" message element
    //             const message = document.createElement("div");
    //             // Add class to the created element
    //             message.setAttribute("class", "no_result");
    //             // Add message text content
    //             message.innerHTML = `<span>Found No Results for "${data.query}"</span>`;
    //             // Append message element to the results list
    //             list.prepend(message);
    //         }
    //     },
    //     noResults: true,
    // },
    // resultItem: {
    //     highlight: {
    //         render: true
    //     }
    // }


});