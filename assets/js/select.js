const optionWrapper = document.getElementById('option-wrapper')
const arrow = document.querySelector('.arrow')
async function fetchCountries() {
    const res = await fetch('https://rest-country-api.p.rapidapi.com/', {
        method: 'GET',
        headers: {
            'X-RapidAPI-Key': '56a2524e12msh8d32a9a56a0a6adp1d008djsn065802268cc7',
            'X-RapidAPI-Host': 'rest-country-api.p.rapidapi.com'
        }
    })

    const data = await res.json()
        .then(data => data.map((country, index) => data[index] = country.name.common))
        .catch((e) => console.log(e))
    return data;
}

window.onload = async () => {
    const countries = await fetchCountries();

    const select = document.getElementById('option-inner')

    countries.map(country =>
        select.innerHTML += `
           <div class="form-item__option" id=${country}>${country}</div>
       `
    )
    addEvent()
};

function handleSelect() {
    optionWrapper.classList.toggle('hide')
    arrow.classList.toggle('open')
}

function addEvent() {
    const options = document.querySelectorAll('.form-item__option')
    const selectedValue = document.getElementById('selected-value')
    const itemSelect = document.getElementById('country')
    document.addEventListener('click', e => {
        let target = e.target;
        let its_selectEl = target == itemSelect || itemSelect.contains(target);
        if (!its_selectEl) {
            optionWrapper.classList.add('hide')
        }
    })
    for (let i = 0; i < options.length; i++) {
        options[i].addEventListener('click', (e) => {
            let value = options[i].innerText ?? "";
            selectedValue.innerText = value;
            options[i].classList.add('option-active')
            for (let j = 0; j < i; j++) {
                options[j].classList.remove('option-active')
            }
            for (let j = i + 1; j < options.length; j++) {
                options[j].classList.remove('option-active')
            }
            e.stopPropagation()
            optionWrapper.classList.add('hide')
            arrow.classList.toggle('open')
        })
    }
}