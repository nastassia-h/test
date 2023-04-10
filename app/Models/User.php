<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DbModel;

/**
 * Class User
 *
 * @package App\Models
 */
class User extends DbModel
{
    /**
     * @var string
     */
    public string $username;
    /**
     * @var string
     */
    public string $email;
    /**
     * @var string
     */
    public string $country;
    /**
     * @var string
     */
    public string $gender;
    /**
     * @var string
     */
    public string $permission = '0';
    /**
     * @var string
     */
    public string $password;
    /**
     * @var string
     */
    public string $repeat_password;

    /**
     * @return string
     */
    protected function tableName(): string
    {
        return 'users';
    }

    /**
     * @return string
     */
    public function primaryKey(): string
    {
        return 'id';
    }

    /**
     * @return int
     */
    public function save(): int
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'country' => [self::RULE_REQUIRED],
            'gender' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
            'repeat_password' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        ];
    }

    /**
     * @return string[]
     */
    protected function attributes(): array
    {
        return ['username', 'email', 'country', 'gender','permission', 'password'];
    }
}
