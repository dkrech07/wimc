const autoCompleteJS = new autoComplete({ 
// API Advanced Configuration Object

    selector: "#autoComplete",
    placeHolder: "Введите название адрес и мы найдем таможни рядом!",

    data: {
      
        src: async query => {
            // console.log('без await');
            // console.log(query);
            try {
                const apiUrl = autoCompleteJS.input.dataset.apiUrl;
                const source = await fetch(`${apiUrl}/${query}`);
                console.log('с await');
                console.log(query);
                const data = await source.json();

                console.log('Пришло от openMaps: ');
                console.log(data);
                return data;
            } catch (error) {
                return error;
            }
        },
        keys: ['display_name'],
        // cache: true,
    },
    threshold: 1,
    debounce: 800,
    searchEngine: "loose",
    diacritics: true,
    resultsList: {
        tag: "ul",
        id: "autoComplete_list",
        class: "results_list",
        destination: "#autoComplete",
        position: "afterend",
        maxResults: 25,
        noResults: true,
        element: (list, data) => {
            list.setAttribute("data-parent", "geo-list");
            console.log('Пришло от autocomplete: ');
            console.log(list);
            console.log(data);
        },
    },
    resultItem: {
        tag: "li",
        class: "autoComplete_result",
        element: (item, data) => {
            item.setAttribute("data-parent", "geo-list");
        },
        highlight: "autoComplete_highlight",
        selected: "autoComplete_selected"
    },
    events: {
        // input: {
        //     focus: (event) => {
        //         console.log("Input Field in focus!");
        //       },
        //     selection: event => {
        //         const selectionValue = event.detail.selection.value;
        //         autoCompleteJS.input.value = selectionValue.display_name;

        //         const latitudeInputElement = document.querySelector('#latitude');
        //         const longitudeInputElement = document.querySelector('#longitude');
        //         // const cityNameInputElement = document.querySelector('#city_name');
        //         // const addressInputElement = document.querySelector('#address');
                
        //         latitudeInputElement.value = selectionValue.lat;
        //         longitudeInputElement.value = selectionValue.lon;
        //         // cityNameInputElement.value = selectionValue.city ? selectionValue.city : 0;
        //         // addressInputElement.value = selectionValue.text ? selectionValue.text : 0;
        //     }
        // }
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