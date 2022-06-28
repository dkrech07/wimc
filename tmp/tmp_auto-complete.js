// const output = document.querySelector('#output');
const autoComplete = document.querySelector('#autoComplete');
const apiUrl = 'geoapi';

// function debounce(f, ms) {

//   let isCooldown = false;

//   return function() {
//     if (isCooldown) return;

//     f.apply(this, arguments);

//     isCooldown = true;

//     setTimeout(() => isCooldown = false, ms);
//   };

// }

function debounce( callback, delay ) {
  let timeout;
  return function() {
      clearTimeout( timeout );
      timeout = setTimeout( callback, delay );
  }
}

var removeChild = function (element) {
  while (element.firstChild) {
    element.removeChild(element.firstChild);
  }
};

async function getGeoObjects(apiUrl, query) {
  try {
    let response = await fetch(`${apiUrl}/${query}`);
    const data = await response.json();
    console.log(query);
    console.log(data);

    let oldContainer = document.querySelector('.geoList');
    if (oldContainer) {
      removeChild(oldContainer);
    }
    let container = document.createElement("ul");
    container.className = 'geoList';
    data.forEach(item => {
      let element = document.createElement("li");
      element.textContent = item['display_name'];
      element.setAttribute("geo_data", [item['lat'], item['lon']])  

      element.addEventListener('click', (evt) => {
        // data.value = evt.target.value
        // console.log('В evt.target.value:');
        console.log(evt.target.attributes.geo_data);
      
   
      
      });

      
      container.appendChild(element);
    });
    autoComplete.after(container);



  } catch (error) {
    return error;
  }
}

const data = {
  _value: '',
  get value() {
    return this._value;
  },
  set value(newValue) {
    this._value = newValue;
    autoComplete.value = newValue;
    //   output.textContent = newValue;
    // getGeoObjects(apiUrl, newValue);
    // console.log('В переменной data:');
    // console.log(newValue);
  }
};

autoComplete.addEventListener('input', (evt) => {
  data.value = evt.target.value
  console.log('В evt.target.value:');
  console.log(evt.target.value);

  debounce(getGeoObjects(apiUrl, data.value), 0);
  // setTimeout(
  //   getGeoObjects(apiUrl, data.value)
  //   // data.value = `Random value is ${Math.random().toFixed(3)}`
  // , 3000);

});






// const returnedFunction = debounce(function() {
//   // Что то делаем
//   console.log('debounce');
// }, 250);

// setInterval(() => {
//   getGeoObjects(apiUrl, data.value);
//   // data.value = `Random value is ${Math.random().toFixed(3)}`
// }, 3000);



