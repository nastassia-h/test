<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Class Model
 *
 * @package App\core
 */
abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    /**
     * @var array
     */
    public array $errors = [];

    /**
     * @param $data
     * @return void
     */
    public function loadData($data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @return array
     */
    abstract protected function rules(): array;

    /**
     * @return bool
     */
    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !preg_match('/^\\S+@\\S+\\.\\S+$/', $value)) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && $value && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    if(isset($rule['id'])) {
                        $id = $rule['id'];
                        $statement = Application::$app->db->connection->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = ? AND id != $id");
                    } else {
                        $statement = Application::$app->db->connection->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = ?");
                    }
                    $statement->bind_param($this->getType($value), $value);
                    $statement->execute();
                    $record = $statement->fetch();
                    if ($record)
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                }
            }
        }
        return empty($this->errors);
    }

    /**
     * @param string $attribute
     * @param string $rule
     * @param array $params
     * @return void
     */
    protected function addErrorForRule(string $attribute, string $rule, array $params = []): void
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace($key, $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    /**
     * @param string $attribute
     * @param string $message
     * @return void
     */
    protected function addError(string $attribute, string $message): void
    {
        $this->errors[$attribute][] = $message;
    }

    /**
     * @return string[]
     */
    private function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be min',
            self::RULE_MAX => 'Max length of this field must be max',
            self::RULE_MATCH => 'This field must be the same as match',
            self::RULE_UNIQUE => 'Record with this field already exists'
        ];
    }

    /**
     * @param $attribute
     * @return string
     */
    protected function getType($attribute): string
    {
        if (is_string($attribute))
            return 's';
        if (is_int($attribute))
            return 'i';
        if (is_float($attribute))
            return 'd';
        return 'b';
    }
}
