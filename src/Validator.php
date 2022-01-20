<?php

namespace Dotenv;

use Exception;

class Validator {
    /**
     * Check that all required variables exists and have a value
     * 
     * @param array $variables
     * 
     * @throws \Exception
     * 
     * @return void
     */
    public function required(array $variables) {
        for ($i=0; $i < count($variables); $i++) { 
            if (!array_key_exists($variables[$i], $_SERVER) && !array_key_exists($variables[$i], $_ENV) && getenv($variables[$i]) == null || strlen(getenv($variables[$i])) == 0) {
                throw new Exception("Required value ".$variables[$i]." not found or is empty");
            }
        }
    }
}