<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

/**
 * Class UpdateForm
 *
 * @package App\Models
 */
class UpdateForm extends Model
{
    /**
     * @var string
     */
    protected string $id;
    /**
     * @var string
     */
    protected string $username;
    /**
     * @var string
     */
    protected string $email;
    /**
     * @var string
     */
    protected string $country;
    /**
     * @var string
     */
    protected string $gender;
    /**
     * @var string
     */
    protected string $permission = '0';
    /**
     * @var string
     */
    protected string $password = '';
    /**
     * @var string
     */
    protected string $repeat_password = '';

    /**
     * @return string
     */
    protected static function tableName(): string
    {
        return 'users';
    }

    /**
     * @return string
     */
    protected static function primaryKey(): string
    {
        return 'id';
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class, 'id' => $this->id]],
            'country' => [self::RULE_REQUIRED],
            'gender' => [self::RULE_REQUIRED],
            'password' => [[self::RULE_MIN, 'min' => 8]],
            'repeat_password' => [[self::RULE_MATCH, 'match' => 'password']]
        ];
    }

    /**
     * @param $attributes
     * @param $user
     * @return int
     */
    public function update($attributes, $user): int
    {
        $foundUser = $user->findOne(['id' => $this->id]);
        $attributes['password'] = password_hash($this->password, PASSWORD_DEFAULT);
        unset($attributes['repeat_password']);

        return $user->update($attributes, ['id'=>$this->id]);
    }

}