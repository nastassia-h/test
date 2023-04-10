function handleForm(e) {
    const errors = document.querySelectorAll('.form-item__error-message')
    const registerBtn = document.getElementById('reg-btn')
    const registerForm = document.getElementById('register')
    const loginForm = document.getElementById('login')
    const formLogin = document.getElementById('form-login')
    const formRegister = document.getElementById('register-form')
    const country = document.getElementById('selected-value')
    if (e.target != registerBtn) {
        loginForm.classList.remove('hide')
        registerForm.classList.add('hide')
        formRegister.reset();
        country.innerText = "";
        errors.forEach(error => error.innerText = "")
    } else {
        loginForm.classList.add('hide')
        registerForm.classList.remove('hide')
        formLogin.reset();
        errors.forEach(error => error.innerText = "")
    }
}

