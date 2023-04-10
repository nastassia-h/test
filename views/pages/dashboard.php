<?php

declare(strict_types=1);

if (!isset($_SESSION['user'])) {
    header('Location: /auth');
}
$user = \App\Core\Application::$app->user;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/global.js" defer></script>
    <script src="assets/js/dashboard.js" defer></script>
    <title>Dashboard</title>
</head>

<body>
    <main class="page fullscreen">
        <section class="dashboard">
            <nav class="dashboard__navbar navbar">
                <div class="navbar__row container">
                    <div class="navbar__username">
                    </div>
                    <button class="btn btn-logout" onclick="handleLogout()">Logout</button>
                </div>
            </nav>
            <div class="dashboard__container container">
                <div class="dashboard__title">Users Management</div>
                <?php if ($user->permission == 1) echo '<button class="btn-show btn" onClick="handleUserCreate()">Create new user</button>' ?>
                <div class="dashboard__body">
                    <table class="dashboard__table" id="dashboard-table">

                    </table>
                </div>
            </div>
        </section>
        <section id="show-popup" class="popup hide glassmorphismpurple slide-bottom">
            <div class="popup__inner">
                <div class="close-btn" onclick="closePopup()">x</div>
                <div class="popup__title">User info</div>
                <div class="popup__body">
                    <table style="width:100%">
                        <tr>
                            <th>Username</th>
                            <td id="show-username">Jill</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td id="show-email">Smith@gmail.com</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td id="show-gender">male</td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td id="show-country">USA</td>
                        </tr>
                    </table>
                </div>
            </div>
        </section>
        <section id="edit-create-popup" class="popup hide glassmorphismpurple slide-bottom">
            <div class="popup__inner">
                <div class="close-btn" onclick="closePopup()">x</div>
                <div id="edit-create-popup-title" class="popup__title">Edit user</div>
                <div class="popup__body">
                    <form id="register-form" class="form__body">
                        <div class="login-form" id="login-form">
                            <div class="register-form__item form-item">
                                <label class="form-item__title" for="username">Username:</label>
                                <div class="form-item__body">
                                    <input class="form-item__input" type="text" id="username" name="username" required>
                                </div>
                                <div class="form-item__error-message" id="errorEl-username-register"></div>
                            </div>
                            <div class="login-form__item form-item">
                                <label class="form-item__title" for="email">Email:</label>
                                <div class="form-item__body">
                                    <input class="form-item__input" type="email" id="email-register" name="email" required>
                                </div>
                                <div class="form-item__error-message" id="errorEl-email-register"></div>
                            </div>
                            <div class="register-form__item form-item">
                                <label class="form-item__title" class="registration-form__item" for="country">Country:</label>
                                <div class="form-item__body">
                                    <div class="form-item__select" name="country" id="country" onclick="handleSelect()">
                                        <div class="form-item__select-value" id="selected-value"></div>
                                        <div class="arrow"></div>
                                        <div class="form-item__option-wrapper hide scale-up-ver-top" id="option-wrapper">
                                            <div class="form-item__option-inner" id="option-inner"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-item__error-message" id="errorEl-country-register"></div>
                            </div>
                            <div class="register-form__item form-item">
                                <label class="form-item__title">Gender:</label>
                                <div class="form-item__radio" id="radio-wrapper">
                                    <div>
                                        <input type="radio" id="radioGenderMale" name="gender" value="male">
                                        <label for="radioGenderMale">male</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="radioGenderFemale" name="gender" value="female">
                                        <label for="radioGenderFemale">female</label>
                                    </div>
                                </div>
                                <div class="form-item__error-message" id="errorEl-gender-register"></div>
                            </div>
                            <div class="login-form__item form-item">
                                <label class="form-item__title" for="password">Password:</label>
                                <div class="form-item__body">
                                    <input class="form-item__input" type="password" id="password-register" name="password" required>
                                </div>
                                <div class="form-item__error-message" id="errorEl-password-register"></div>
                            </div>
                            <div class="register-form__item form-item">
                                <label class="form-item__title" for="repeat_password">Repeat password:</label>
                                <div class="form-item__body">
                                    <input class="form-item__input" type="password" id="repeat_password" name="repeat_password" required>
                                </div>
                                <div class="form-item__error-message" id="errorEl-repeat_password-register"></div>
                            </div>
                        </div>
                        <div class="register-form__item form-item" style="margin-bottom: 0.5rem">
                            <div class="form-item__body">
                                <input class="form-item__checkbox" type="checkbox" id="permission" name="permission">
                                <label class="form-item__title" for="permission">Admin permission</label>
                            </div>
                            <div class="form-item__error-message" id="errorEl-repeat_password-register"></div>
                        </div>
                        <button type="submit" id="sub-btn-register" class="form__submit-btn btn btn-active">Save</button>
                        <div class="register-popup slide-bottom hide">User was successfully registered! Login</div>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>

</html>