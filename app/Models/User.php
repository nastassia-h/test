<?php

namespace App\Models;

use App\Services\Database;

class User extends Database
{
   private $table_name = "users";

   private $inputs;

   private $username;
   private $email;
   private $country;
   private $password;
   private $repeatpassword;
   private $gender;

   function __construct(array $inputs)
   {
      parent::__construct();

      $this->inputs = $inputs;

      $this->username = $this->inputs['username'];
      $this->email = $this->inputs['email'];
      $this->country = $this->inputs['country'];
      $this->password = $this->inputs['password'];
      $this->repeatpassword = $this->inputs['repeatpassword'];
      $this->gender = $this->inputs['gender'];
   }

   public function getArray(): array
   {
      return array("username" => $this->username, "email" => $this->email, "country" => $this->country, "password" => password_hash($this->password, PASSWORD_BCRYPT), "gender" => $this->gender);
   }

   public function validateName()
   {
      return (preg_match('/^[a-z\d_]{2,20}$/i', $this->username) && (strlen($this->username) > 0));
   }

   public function validateEmail()
   {
      return (filter_var($this->email, FILTER_VALIDATE_EMAIL) && !(new Database)->select($this->table_name, 'email = ?', [$this->email]) && (strlen($this->email) > 0));
   }

   public function validateCountry()
   {
      return (strlen($this->country) > 0);
   }

   public function validatePassword()
   {
      return true;
      //return (preg_match('^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$', $this->password) && (strlen($this->password) > 0));
   }

   public function validateRepeatpassword()
   {
      return ($this->password === $this->repeatpassword);
   }

   public function validateGender()
   {
      return (strlen($this->gender) > 0);
   }
}
