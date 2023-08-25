<?php

namespace app\core;



abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    public function loadData($data)
    {
        foreach ($data as $key => $value){
            if (property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }

    }

    abstract public function rules(): array;

    public function labels():array
    {
        return [];
    }

    public array $errors = [];

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }

                switch ($ruleName) {
                    case self::RULE_REQUIRED:
                        if (empty($value) || strlen(trim($value)) === 0) {
                            $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                        }
                        break;
                    case self::RULE_EMAIL:
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $this->addErrorForRule($attribute, self::RULE_EMAIL, ['email' => $this->getLabel($attribute)]);
                        }
                        break;
                    case self::RULE_MIN:
                        if (strlen($value) < $rule['min']) {
                            $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                        }
                        break;
                    case self::RULE_MAX:
                        if (strlen($value) > $rule['max']) {
                            $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                        }
                        break;
                    case self::RULE_MATCH:
                        $matchAttribute = $rule['match'];
                        if ($value !== $this->{$matchAttribute}) {
                            $this->addErrorForRule($attribute, self::RULE_MATCH, ['match' => $this->getLabel($matchAttribute)]);
                        }
                        break;
                    case self::RULE_UNIQUE:
                        $className = $rule['class'];
                        $uniqueAttr = $rule['attribute'] ?? $attribute;
                        $tableName = $className::tableName();
                        $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                        $statement->bindValue(":attr", $value);
                        $statement->execute();
                        $record = $statement->fetchObject();
                        if ($record) {
                            $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $this->getLabel($attribute)]);
                        }
                        break;
                }
            }
        }

        return empty($this->errors);
    }
    private function addErrorForRule(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMassages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}",$value, $message);
        }
        $this->errors[$attribute][]= $message;
    }

    public function addError(string $attribute, string $message)
    {

        $this->errors[$attribute][]= $message;
    }

    public function errorMassages()
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid {email} address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record  with this {field} already exists',
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ??false;
    }

    public function getLabel($attribute): ?string
    {
        if ($attribute === 'id') {
            return null;
        }
        return $this->labels()[$attribute] ?? $attribute;
    }

}