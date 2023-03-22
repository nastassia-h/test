<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Registration form</title>
   <link rel="stylesheet" href="assets/css/style.css">
   <script defer src="assets/js/auth.js"></script>
</head>

<body>
   <div class="wrapper">
      <main class="page">
         <section class="registration">
            <div class="registration__banner"></div>
            <div class="registration__body">
               <div class="registration-form">
                  <div class="refistration-form__inner">
                     <div class="registration-form__title">Registration form</div>
                     <form class="registration-form__body" method="post" id="register-form" onsubmit="register(event)">
                        <div class="registration-form__row">
                           <div class="registration-form__item form-item">
                              <label class="form-item__title" for="username">Username:</label>
                              <div class="form-item__body">
                                 <div class="form-item__icon"></div>
                                 <input class="form-item__input" type="text" id="username" name="username" required>
                              </div>
                           </div>
                           <div class="registration-form__item form-item">
                              <label class="form-item__title" for="email">Email:</label>
                              <div class="form-item__body">
                                 <div class="form-item__icon form-item__icon_email">@</div>
                                 <input class="form-item__input" type="email" id="email" name="email" required>
                              </div>
                           </div>
                           <div class="registration-form__item form-item">
                              <label class="form-item__title" for="password">Password:</label>
                              <div class="form-item__body">
                                 <div class="form-item__icon"></div>
                                 <input class="form-item__input" type="password" id="password" name="password" required>
                              </div>
                           </div>
                           <div class="registration-form__item form-item">
                              <label class="form-item__title" for="repeatpassword">Repeat password:</label>
                              <div class="form-item__body">
                                 <div class="form-item__icon"></div>
                                 <input class="form-item__input" type="password" id="repeatpassword" name="repeatpassword" required>
                              </div>
                           </div>
                           <div class="registration-form__item form-item">
                              <label class="form-item__title" class="registration-form__item" for="country">Country:</label>
                              <div class="form-item__body">
                                 <div class="form-item__icon"></div>
                                 <div class="form-item__icon form-item__icon_end"></div>
                                 <input class="form-item__input" type="text" id="country" name="country" required>
                              </div>
                           </div>
                           <div class="registration-form__item form-item">
                              <label class="form-item__title" for="gender">Gender:</label>
                              <div class="form-item__body">
                                 <div class="form-item__icon"></div>
                                 <div class="form-item__icon form-item__icon_end"></div>
                                 <input class="form-item__input" type="text" id="gender" name="gender" required>
                              </div>
                           </div>
                        </div>
                        <div class="registration-form__row">
                           <div class="registration-form__check">
                              <input type="checkbox" id="agreement" name="agreement" value="agree" />
                              <label for="agreement">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</label>
                           </div>
                           <button class="registration-form__btn btn" type="submit">Register now</button>
                        </div>
                        <div class="errors" id="errors">

                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </section>
      </main>
   </div>

</body>

</html>