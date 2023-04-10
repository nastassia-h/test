<?php
if (isset($_SESSION['user'])) {
    header('Location: /');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/global.js" defer></script>
    <script src="assets/js/auth.js" defer></script>
    <script src="assets/js/form.js" defer></script>
    <script src="assets/js/select.js" defer></script>
    <title>Sign in</title>
</head>

<body>
    <main class="page fullscreen">
        <section class="form">
            <div class="gradient-01 grd grd-1 moving-left"></div>
            <div class="gradient-02 grd grd-2 moving-right"></div>
            <div class="gradient-0 grd grd-3 moving-left"></div>
            <section id="login" class="form__container glassmorphism slide-bottom">
                <div class="form__title title" id="form-title">Login form</div>
                <div class="form__controls">
                    <button id="log-btn" class="form__btn btn" onclick="handleForm(event)">Login</button>
                    <button id="reg-btn" class="form__btn btn btn-nonactive" onclick="handleForm(event)">Signup</button>
                </div>
                <?php include_once './views/components/loginForm.php' ?>
            </section>
            <section id="register" class="form__container glassmorphism slide-bottom hide">
                <div class="form__title title" id="form-title">Registration form</div>
                <div class="form__controls">
                    <button id="log-btn" class="form__btn btn btn-nonactive" onclick="handleForm(event)">Login</button>
                    <button id="reg-btn" class="form__btn btn " onclick="handleForm(event)">Signup</button>
                </div>
                <?php include_once './views/components/registerForm.php' ?>
                <div class="register-popup slide-bottom hide">User was successfully registered! Login</div>
            </section>
        </section>
    </main>
</body>

</html>