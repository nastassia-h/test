<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Middlewares\AuthMiddleware;
use App\Models\User;
use App\Models\UpdateForm;

/**
 * Class UserController
 *
 * @package App\Controllers
 */
class UserController extends Controller
{
    public array $middlewares = [AuthMiddleware::class];
    /**
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function getUsers(Request $request, User $user): void
    {
        $params = $request->getBody();
        if (!isset($params['column']) && !isset($params['order'])) {
            $params['column'] = '';
            $params['order'] = '';
        }
        $users = $user->getAll($params['column'], $params['order']);
        header('Content-Type: application/json');
        echo json_encode(['status' => true, 'permission' => $user->permission, 'data' => $users]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function delete(Request $request, User $user): void
    {
        $delete_status = $user->delete(['id' => $request->getParams()]);
        http_response_code(204);
        echo json_encode(['status' => $delete_status]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function show(Request $request, User $user): void
    {
        $foundUser = $user->findOne(['id' => $request->getParams()]);
        header('Content-Type: application/json');
        echo json_encode(['status' => (bool)$foundUser, 'data' => $foundUser]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function update(Request $request, User $user): void
    {
        $id = $request->getParams();
        $attributes = json_decode(file_get_contents('php://input'), true);

        $updateForm = new UpdateForm();
        $updateForm->loadData(['id' => $id]);
        $updateForm->loadData($attributes);

        $update_status = $updateForm->validate() && $updateForm->update($attributes, $user);
        http_response_code(201);
        echo json_encode(['status' => $update_status, 'data' => $updateForm->errors]);
    }
}
