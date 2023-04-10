<form id="form-login" class="form__body" method="POST" onsubmit="login(event)">
    <div class="login-form vertical" id="login-form">
        <div class="login-form__item form-item">
            <label class="form-item__title" for="email">Email:</label>
            <div class="form-item__body">
                <input class="form-item__input" type="email" id="email" name="email" required>
            </div>
            <div class="form-item__error-message" id="errorEl-email"></div>
        </div>
        <div class="login-form__item form-item">
            <label class="form-item__title" for="password">Password:</label>
            <div class="form-item__body">
                <input class="form-item__input" type="password" id="password" name="password" required>
            </div>
            <div class="form-item__error-message" id="errorEl-password"></div>
        </div>
    </div>
    <button type="submit" id="sub-btn-login" class="form__submit-btn btn btn-active">Login</button>
</form>