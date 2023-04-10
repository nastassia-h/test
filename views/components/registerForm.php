 <form id="register-form" class="form__body" method="POST" onsubmit="register(event)">
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
                    <input class="form-item__input" type="password" id="repeat_password" name="repeat_password"
                           required>
                </div>
                <div class="form-item__error-message" id="errorEl-repeat_password-register"></div>
            </div>
        </div>
        <div class="register-form__item form-item" style="margin: 1rem 0">
            <div class="form-item__body">
                <input class="form-item__checkbox" type="checkbox" id="permission" name="permission">
                <label class="form-item__title" for="permission">Admin permission</label>
            </div>
            <div class="form-item__error-message" id="errorEl-repeat_password-register"></div>
         </div>
        <button  type="submit" id="sub-btn-register" class="form__submit-btn btn btn-active">Register</button>
 </form>
