<?php

namespace fkrzski\Dotenv;

use fkrzski\Dotenv\Exceptions\ValidationException;

class Validator {
    /**
     * Validate a given variables
     * 
     * @param array $variables Variables to be validated
     * 
     * @return void
     */
    public function validate(array $variables) {
        $variables = $this->resolveValidationRules($variables);
        foreach ($variables as $key => $value) {
            $this->callValidationMethod($key, $value);
        }
    }

    /**
     * Resolve a string of rules into an array
     * 
     * @param array $rules String of rules to validation
     * 
     * @return array
     */
    protected function resolveValidationRules($rules) {
        foreach ($rules as $key => $value) {
            $rules[$key] = explode('|', $value);
        }
        return $rules;
    }

    /**
     * Call a specific method of validating variables
     * 
     * @param string $name The name of variable
     * @param mixed $rules The name of the validation rule
     * 
     * @return void
     */
    protected function callValidationMethod($name, $rules) {
        foreach ($rules as $key => $value) {
            $this->$value($name);
        }
    }
    

    /**
     * Check that variable exists and have a value
     * 
     * @param string $name Variable name that must be included in the '.env' file
     * 
     * @throws fkrzski\Dotenv\Exceptions\ValidationException
     * 
     * @return void
     */
    public function required($name) {
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV) && getenv($name) == null || strlen(getenv($name)) == 0) {
            throw new ValidationException(sprintf("Required value %s not found or is empty", $name));
        }
    }

    /**
     * Check if value have only letters and spaces
     * 
     * @param string $name Variable name that must be included in the '.env' file
     * 
     * @throws fkrzski\Dotenv\Exceptions\ValidationException
     * 
     * @return void
     */
    public function letters($name) {
        if (!ctype_alpha(str_replace(" ", "", $_SERVER[$name])) && !ctype_alpha(str_replace(" ", "", $_ENV[$name])) && !ctype_alpha(str_replace(" ", "", getenv($name)))) {
            throw new ValidationException(sprintf("Value %s do not have only letters and spaces", $name));
        }
    }

    /**
     * Check if value have only alphanumeric characters and spaces
     * 
     * @param string $name Variable name that must be included in the '.env' file
     * 
     * @throws fkrzski\Dotenv\Exceptions\ValidationException
     * 
     * @return void
     */
    public function alnum($name) {
        if (!ctype_alnum(str_replace(" ", "", $_SERVER[$name])) && !ctype_alnum(str_replace(" ", "", $_ENV[$name])) && !ctype_alnum(str_replace(" ", "", getenv($name)))) {
            throw new ValidationException(sprintf("Value %s do not have only letters, numbers and spaces", $name));
        }
    }

    /**
     * Check if value is an integer (Only numbers)
     * 
     * @param string $name Variable name that must be included in the '.env' file
     * 
     * @throws fkrzski\Dotenv\Exceptions\ValidationException
     * 
     * @return void
     */
    public function integer($name) {
        if (!filter_var($_SERVER[$name], FILTER_VALIDATE_INT) && !filter_var($_ENV[$name], FILTER_VALIDATE_INT) && !filter_var(getenv($name), FILTER_VALIDATE_INT)) {
            throw new ValidationException(sprintf("Value %s is not an integer", $name));
        }
    }

    /**
     * Check if value is an boolean (true, false)
     * 
     * @param string $name Variable name that must be included in the '.env' file
     * 
     * @throws fkrzski\Dotenv\Exceptions\ValidationException
     * 
     * @return void
     */
    public function boolean($name) {
        if (filter_var($_SERVER[$name], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === null && filter_var($_ENV[$name], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === null && filter_var(getenv($name), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === null) {
            throw new ValidationException((sprintf("Value %s is not an boolean", $name)));
        }
    }

    /**
     * Check if value is an boolean (true, false)
     * 
     * @param string $name Variable name that must be included in the '.env' file
     * 
     * @throws fkrzski\Dotenv\Exceptions\ValidationException
     * 
     * @return void
     */
    public function float($name) {
        if (!filter_var($_SERVER[$name], FILTER_VALIDATE_FLOAT) && !filter_var($_ENV[$name], FILTER_VALIDATE_FLOAT) && !filter_var(getenv($name), FILTER_VALIDATE_FLOAT)) {
            throw new ValidationException((sprintf("Value %s is not an float", $name)));
        }
    }
}