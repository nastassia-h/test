async function register(e) {
   e.preventDefault()
   const form = document.getElementById('register-form')
   const errordiv = document.getElementById('errors')
   const username = document.getElementById('username').value
   const email = document.getElementById('email').value
   const country = document.getElementById('country').value
   const password = document.getElementById('password').value
   const repeatpassword = document.getElementById('repeatpassword').value
   const gender = document.getElementById('gender').value
   const agreement = document.getElementById('agreement').checked



   if (agreement) {
      let formDate = new FormData();
      formDate.append('username', username)
      formDate.append('email', email)
      formDate.append('country', country)
      formDate.append('password', password)
      formDate.append('repeatpassword', repeatpassword)
      formDate.append('gender', gender)
      const res = await fetch('http://regform/auth/register', {
         method: 'POST',
         body: formDate
      })

      const data = await res.json();

      if (data.status === true) {
         form.reset()
         errordiv.style.color = "green"
         errordiv.innerHTML = `<p>User was created!</p>`;
         setTimeout(() => {
            errordiv.innerHTML = ""
         }, 1000);
      } else {
         errordiv.style.color = "red"
         errordiv.innerHTML = `<p>${data.message}</p>`;
      }

      return data;
   } else {
      errordiv.style.color = "red"
      errordiv.innerHTML += `<p>You need to confirm the agreement!</p>`;
   }
}