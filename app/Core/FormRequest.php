<?php

namespace App\Core;

use App\Core\Request;

abstract class FormRequest extends Request
{
    private array $__rules = [];
    private array $__messages = [];
    private array $errors = [];

    public function __construct()
    {
        $this->__rules = $this->rules();
        $this->__messages = $this->messages();
    }

    abstract public function rules();

    abstract public function messages();

    public function validate()
    {
        $request = $this->getBody();
        $this->__rules = array_filter($this->__rules);

        if (!empty($this->__rules)) {
            foreach ($this->__rules as $fieldName => $ruleItem) {
                if (is_array($ruleItem)) {
                    $ruleItemArr = $ruleItem;
                } else {
                    $ruleItemArr = explode('|', $ruleItem);
                }

                foreach ($ruleItemArr as $rules) {
                    $ruleName = null;
                    $ruleValue = null;
                    $rulesArr = explode(':', $rules);
                    $ruleName = reset($rulesArr);

                    if (count($rulesArr) > 1) {
                        $ruleValue = end($rulesArr);
                    }

                    if ($ruleName === 'required') {
                        if (empty(trim($request[$fieldName]))) {
                            $this->setErrors($fieldName, $ruleName);
                        }
                    }

                    if ($ruleName === 'regex') {
                        if (!preg_match($ruleValue, $request[$fieldName])) {
                            $this->setErrors($fieldName, $ruleName);
                        }
                    }

                    if ($ruleName === 'after') {
                        if (strtotime($request[$fieldName]) < strtotime($request[$ruleValue])) {
                            $this->setErrors($fieldName, $ruleName);
                        }
                    }

                    if ($ruleName === 'in') {
                        if (!in_array($request[$fieldName], explode(',', $ruleValue))) {
                            $this->setErrors($fieldName, $ruleName);
                        }
                    }
                }
            }
        }

        return empty($this->errors);
    }

    public function getFirstErrors()
    {
        $errors = [];

        foreach ($this->errors as $key => $error) {
            $errors[$key] = reset($error);
        }

        return $errors;
    }

    protected function setErrors($fieldName, $ruleName)
    {
        $this->errors[$fieldName][$ruleName] = $this->__messages["$fieldName.$ruleName"];
    }
}