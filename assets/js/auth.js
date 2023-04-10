async function register(e) {
   e.preventDefault()
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
      body: formData
   })

   const data = await res.json();
   const resolved = data.status;

   if (resolved) {
      const registerSuccess = document.querySelector('.register-popup')
      const registerForm = document.getElementById('register')
      const loginForm = document.getElementById('login')
      registerSuccess.classList.remove('hide')
      setTimeout(() => {
         registerSuccess.classList.add('hide')
         loginForm.classList.remove('hide')
         registerForm.classList.add('hide')
         form.reset()
      }, 2000)
   } else {
      const errors = Object.keys(data?.data)
      errors.forEach(error => {
         const errorEl = document.getElementById(`errorEl-${error}-register`)
         errorEl.innerText = `*${data.data[error]}`
      })
   }
}
async function login(e) {
   e.preventDefault()
   const email = document.getElementById('email').value
   const password = document.getElementById('password').value

   const errors = document.querySelectorAll('.form-item__error-message')
   errors.forEach(error => error.innerText = "")

   const formData = new FormData()
   formData.append('email', email)
   formData.append('password', password)

   const res = await fetch('http://regform/authLogin', {
      method: 'POST',
      body: formData
   })

   const { status, data } = await res.json();

   if (status) {
      const { user, token } = data
      loggedUser.username = user.username
      loggedUser.email = user.email
      loggedUser.country = user.country
      loggedUser.gender = user.gender
      loggedUser.permission = user.permission
      localStorage.setItem('user', JSON.stringify(loggedUser))
      localStorage.setItem('ACCESS_TOKEN', token)
      window.location.replace('http://regform/')
   } else {
      const errors = Object.keys(data)
      errors.forEach(error => {
         const errorEl = document.getElementById(`errorEl-${error}`)
         errorEl.innerText = `*${data[error]}`
      })
   }
   return data;
}
