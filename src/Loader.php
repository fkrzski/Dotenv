<?php

namespace fkrzski\Dotenv;

use fkrzski\Dotenv\Exceptions\FileNotFoundException;
use fkrzski\Dotenv\Exceptions\InvalidSyntaxException;

class Loader {
    /**
     * Paths to the files with environment variables
     * 
     * @var array
     */
    protected $paths;

    /**
     * Create new Loader instance
     * 
     * @param string $paths Paths to the files with the environment variables
     */
    public function __construct($paths) {
        $this->paths = $paths;
    }

    /**
     * Load variables from .env file
     * 
     * @param array $overwritten Variables names that can be overwritten
     * 
     * @return void
     */
    public function load($overwritten) {
        return $this->loadFiles($overwritten);
    }

    public function loadLines($file, $overwritten)
    {
        foreach ($file as $lines => $line) {
            if ($line != "\n") {
                $data = Parser::parseLine($line);
                if ($data !== null) {
                    $this->setEnvVariable($data[0], $data[1], $overwritten);
                }
            }
        }
    }


    /**
     * Check if file is file, exists and and if path is readable
     * 
     * @param array $overwritten Variables names that can be overwritten
     * 
     * @throws fkrzski\Dotenv\Exceptions\FileNotFoundException 
     * 
     * @return mixed
     */
    protected function loadFiles($overwritten) {

        foreach ($this->paths as $key => $value) {
            if (!is_readable($value) && !is_file($value) && !file_exists($value)) {
                throw new FileNotFoundException(sprintf("File %s not found", $value));
            }
            $this->loadLines(file($value, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES), $overwritten);
        }
    }

    /**
     * Check a whether a variable value van be assigned or changed
     * 
     * @param string $name        The name of the new variable 
     * @param array  $overwritten Variables names that can be overwritten
     * 
     * @return bool
     */
    protected function checkChangingPossibility($name, $overwritten) {
        if (in_array('*', $overwritten) && count($overwritten) == 1) {
            return true;
        } elseif (in_array($name, $overwritten)) {
            return true;
        } elseif (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_SERVER) && getenv($name) == null) {
            return true;
        }
        return false;
    }

    /**
     * Set variable to getenv() function
     * 
     * @param string $name        The name of the new variable
     * @param string $value       The value of the new variable
     * @param array  $overwritten Variables names that can be overwritten
     * 
     * @return void
     */
    public function setEnvVariable($name, $value, $overwritten) {
        if ($this->checkChangingPossibility($name, $overwritten)) {
            $value = Parser::parseValue($value);
            putenv("$name=$value");
            $_SERVER[$name] = $value;
            $_ENV[$name]    = $value;
        }
        return;
    }
}