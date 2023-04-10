<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Application;
use App\Core\Model;

/**
 * Class LoginForm
 *
 * @package App\Models
 */
class LoginForm extends Model
{
    /**
     * @var string
     */
   protected string $email;
    /**
     * @var string
     */
   protected string $password;

    /**
     * @return array[]
     */
   protected function rules(): array
   {
      return [
         'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
         'password' => [self::RULE_REQUIRED]
      ];
   }

    /**
     * @param $user
     * @return bool
     */
   public function login($user): bool
   {
      $user = $user->findOne(['email' => $this->email]);
      if (!$user) {
         $this->addError('email', 'User does not exist with this email');
         return false;
      }
      if (!password_verify($this->password, $user->password)) {
         $this->addError('password', 'Password is incorrect');
         return false;
      }
      return Application::$app->login($user);
   }
}
