<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\Database;

class AuthValidator
{
   private $message = null;

   public function userValidation(array $data)
   {
      return $this->validate(new User($data));
   }

   public function insertUser(User $user)
   {
      return (new Database)->insert("users", $user->getArray());
   }

   public function validate(User $user)
   {
      if (!$user->validateName())
         $this->message .= 'Invalid username<br>';
      if (!$user->validateEmail())
         $this->message .= 'Invalid email<br>';
      if (!$user->validateCountry())
         $this->message .= 'Invalid country<br>';
      if (!$user->validatePassword())
         $this->message .= 'Invalid password<br>';
      if (!$user->validateRepeatPassword())
         $this->message .= 'Repeat password and Password are not equal<br>';
      if (!$user->validateGender())
         $this->message .= 'Invalid gender<br>';

      if (!$this->message) {
         $this->message = $this->insertUser($user);
         return ["status" => true, "message" => $this->message];
      } else
         return ["status" => false, "message" => $this->message];
   }
}
