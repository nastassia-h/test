const optionWrapper = document.getElementById('option-wrapper')
const arrow = document.querySelector('.arrow')
const columnOrder = { username: 'asc', email: 'asc' }
let popup = '';
async function getUsers(column = 'username', order = 'asc') {
    const res = await fetch(`http://regform/users?column=${column}&order=${order}`, {
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('ACCESS_TOKEN')}`,
        },
    })

    const { status, permission, data } = await res.json()
    const resolved = status

    if (!resolved) {
        return;
    }
    const users = data
    const table = document.getElementById('dashboard-table')
    table.innerHTML = `
        <tr>
            <th>№</th>
            <th style="cursor: pointer" onclick="handleSort('username')">Name</th> 
            <th style="cursor: pointer" onclick="handleSort('email')">Email</th>
           <th>Action</th>
        </tr>`

    users.map((user, index) => {
        return table.innerHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${user.username}</td>
                <td>${user.email}</td>
                <td class="btn-wrapper">
                    <button class="btn-show btn" onClick="handleUserShow(${user.id})">Show</button>
                    ${permission == 1 ? `<button class="btn-edit btn" onClick="handleUserEdit(${user.id})">Edit</button>
                    <button class="btn-delete btn" onClick="handleUserDelete(${user.id})">Delete</button>` : ``}
                </td>
            </tr>`
    }
    )
}

async function handleSort(column) {
    columnOrder.column = columnOrder.column === 'asc' ? 'desc' : 'asc'
    await getUsers(column, columnOrder.column)
}
async function handleUserDelete(userId) {
    if (window.confirm("Are you sure you want to delete this user?")) {
        const res = await fetch(`http://regform/user/${userId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('ACCESS_TOKEN')}`,
            },
        })

        const { status } = await res.json()
        const resolved = status

        if (resolved) {
            await getUsers();
        }
    }
}

function addCloseEvent(id) {
    const popup = document.getElementById(id)
    document.addEventListener('click', e => {
        e.stopPropagation();
        let target = e.target;
        let its_selectEl = target == popup || popup.contains(target);
        let its_btn = target.classList.contains('btn')
        if (!its_selectEl && !its_btn) {
            popup.classList.add('hide')
        }
    })
}

async function getUser(userId) {
    const res = await fetch(`http://regform/user/${userId}`, {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('ACCESS_TOKEN')}`,
        },
    })
    return await res.json();
}

const form = document.getElementById('register-form')
const popupTitle = document.getElementById('edit-create-popup-title');
const username = document.getElementById('username')
const email = document.getElementById('email-register')
const country = document.getElementById('selected-value')
const password = document.getElementById('password-register')
const repeat_password = document.getElementById('repeat_password')
const errors = document.querySelectorAll('.form-item__error-message')
const submitBtn = document.getElementById('sub-btn-register')

async function handleUserShow(userId) {
    const username = document.getElementById('show-username')
    const email = document.getElementById('show-email')
    const country = document.getElementById('show-country')
    const gender = document.getElementById('show-gender')
    const showPopup = document.getElementById('show-popup');
    showPopup.classList.remove('hide')

    const { status, data } = await getUser(userId)

    if (status) {
        username.innerText = data.username
        email.innerText = data.email
        country.innerText = data.country
        gender.innerText = data.gender
    }
}
function editUser(userId) {
    form.onsubmit = async (event) => {
        event.preventDefault()
        const username = document.getElementById('username').value
        const email = document.getElementById('email-register').value
        const country = document.getElementById('selected-value').innerText
        const password = document.getElementById('password-register').value
        const repeat_password = document.getElementById('repeat_password').value
        const gender = document.querySelector('input[name="gender"]:checked')?.value ?? ''
        const permission = document.getElementById('permission').checked
        const errors = document.querySelectorAll('.form-item__error-message')

        errors.forEach(error => error.innerText = "")

        const userData = {
            username: username,
            email: email,
            country,
            gender,
        }
        if (password) userData.password = password;
        if (repeat_password) userData.repeat_password = repeat_password;
        if (permission) userData.permission = permission;

        const res = await fetch(`http://regform/user/${userId}`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('ACCESS_TOKEN')}`,
            },
            body: JSON.stringify(userData),
        })

        const data = await res.json();
        const resolved = data.status;

        if (resolved) {
            const registerSuccess = document.querySelector('.register-popup')
            registerSuccess.innerText = "User was successfully updated!"
            const registerForm = document.getElementById('edit-create-popup')
            registerSuccess.classList.remove('hide')
            setTimeout(() => {
                registerSuccess.classList.add('hide')
                registerForm.classList.add('hide')
                form.reset()
                getUsers();
            }, 2000)
        } else {
            const errors = Object.keys(data?.data)
            errors.forEach(error => {
                const errorEl = document.getElementById(`errorEl-${error}-register`)
                errorEl.innerText = `*${data.data[error]}`
            })
        }
    }
}
async function handleUserEdit(userId) {
    popup = 'edit';
    submitBtn.onclick = editUser(userId);
    const editPopup = document.getElementById('edit-create-popup');
    editPopup.classList.remove('hide')
    popupTitle.innerText = 'Edit user info'
    const passwordEl = document.getElementById('password-register')
    passwordEl.required = false
    const repeat_passwordEl = document.getElementById('repeat_password')
    repeat_passwordEl.required = false

    const { status, data } = await getUser(userId)

    if (status) {
        username.value = data.username
        email.value = data.email
        country.innerText = data.country
        const gender = document.getElementById(`radioGender${data.gender.slice(0, 1).toUpperCase() + data.gender.slice(1)}`)
        gender.checked = true
        const permission = document.getElementById('permission')
        permission.checked = data.permission === '1'
    }
}

function userCreate() {
    form.onsubmit = async (event) => {
        event.preventDefault()
        const form = document.getElementById('register-form')
        const username = document.getElementById('username').value
        const email = document.getElementById('email-register').value
        const country = document.getElementById('selected-value').innerText
        const password = document.getElementById('password-register').value
        const repeat_password = document.getElementById('repeat_password').value
        const gender = document.querySelector('input[name="gender"]:checked')?.value ?? ''
        const permission = document.getElementById('permission').checked
        const errors = document.querySelectorAll('.form-item__error-message')

        errors.forEach(error => error.innerText = "")

        let formData = new FormData();
        formData.append('username', username)
        formData.append('email', email)
        formData.append('country', country)
        formData.append('password', password)
        formData.append('repeat_password', repeat_password)
        formData.append('gender', gender)
        permission && formData.append('permission', 1)
        const res = await fetch('http://regform/authRegister', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('ACCESS_TOKEN')}`,
            },
            body: formData
        })

        const data = await res.json();
        const resolved = data.status;

        if (resolved) {
            const registerSuccess = document.querySelector('.register-popup')
            registerSuccess.innerText = "User was successfully created!"
            const registerForm = document.getElementById('edit-create-popup')
            registerSuccess.classList.remove('hide')
            setTimeout(() => {
                registerSuccess.classList.add('hide')
                registerForm.classList.add('hide')
                form.reset()
                getUsers();
            }, 2000)
        } else {
            const errors = Object.keys(data?.data)
            errors.forEach(error => {
                const errorEl = document.getElementById(`errorEl-${error}-register`)
                errorEl.innerText = `*${data.data[error]}`
            })
        }
    }
}
async function handleUserCreate() {
    submitBtn.onclick = userCreate();
    form.reset()
    country.innerText = ''
    const createPopup = document.getElementById('edit-create-popup');
    createPopup.classList.remove('hide')
    popupTitle.innerText = 'Create new user'
    const passwordEl = document.getElementById('password-register')
    passwordEl.required = true
    const repeat_passwordEl = document.getElementById('repeat_password')
    repeat_passwordEl.required = true
}

function closePopup() {
    const popups = document.querySelectorAll('.popup')
    popups.forEach(popup => popup.classList.add('hide'))
}

window.onload = async () => {
    const navUsername = document.querySelector('.navbar__username')
    navUsername.innerText = JSON.parse(localStorage.getItem('user')).username
    await getUsers();
    const countries = await fetchCountries();

    const select = document.getElementById('option-inner')

    countries.map(country =>
        select.innerHTML += `
           <div class="form-item__option" id=${country}>${country}</div>
       `
    )
    addEvent()
    addCloseEvent('show-popup')
    addCloseEvent('edit-create-popup')
};

async function handleLogout() {
    const res = await fetch('http://regform/authLogout')
    window.location.replace('/auth')
}
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

