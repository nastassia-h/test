<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\LoginForm;
use App\Models\User;

/**
 * Class AuthController
 *
 * @package App\Controllers
 */
class AuthController extends Controller
{
    /**
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function register(Request $request, User $user): void
    {
        $user->loadData($request->getBody());
        $register_status = $user->validate() && $user->save();

        echo json_encode(['status' => $register_status, 'data' => $user->errors]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function login(Request $request, User $user): void
    {
        $login_form = new LoginForm();
        $login_form->loadData($request->getBody());

        $login_status = $login_form->validate() && $login_form->login($user);

        $loggedUser = $user->findOne(['email' => $request->getBody()['email']]);

        header('Content-Type: application/json');
        echo json_encode(['status' => $login_status, 'data' => empty($login_form->errors) ? ['user' => $loggedUser, 'token' => $_SESSION['token']] : $login_form->errors]);
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        unset($_SESSION['user']);
        unset($_SESSION['token']);
    }
}
