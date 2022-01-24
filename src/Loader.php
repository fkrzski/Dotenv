<?php

namespace Dotenv;

use Dotenv\Exceptions\FileNotFoundException;
use Dotenv\Exceptions\InvalidSyntaxException;

class Loader {
    /**
     * The name of the file with environment variables
     * 
     * @var string
     */
    protected $fileName;

    /**
     * Path to the file with environment variables
     * 
     * @var string
     */
    protected $path;

    /**
     * Create new Loader instance
     * 
     * @param string $fileName The name of the file with the environment variables
     * @param string $path     Path to the file with the environment variables
     */
    public function __construct($fileName, $path) {
        $this->fileName = $fileName;
        $this->path     = $path;
    }

    /**
     * Load variables from .env file
     * 
     * @param array $overwritten Variables names that can be overwritten
     * 
     * @return void
     */
    public function load($overwritten) {
        $file = $this->checkFile();
        foreach ($file as $lines => $line) {
            if ($line != "\n") {
                $data = $this->parseLine($line);
                $this->setEnvVariable($data[0], $data[1], $overwritten);
            }
        }
    }


    /**
     * Check if file is file, exists and and if path is readable
     * 
     * @throws \Dotenv\Exceptions\FileNotFoundException 
     * 
     * @return mixed
     */
    protected function checkFile() {
        if (!is_readable($this->path.$this->fileName) && !is_file($this->path.$this->fileName) && !file_exists($this->path.$this->fileName)) {
            throw new FileNotFoundException(sprintf("File %s not found in %s", $this->fileName, $this->path));
        } 
        return file($this->path.$this->fileName, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
    }

    /**
     * Explode a line to array 
     * 
     * @param string $line Line with data from '.env' file
     * 
     * @throws \Dotenv\Exceptions\InvalidSyntaxException
     * 
     * @return string[]
     */
    protected function parseLine($line) {
        if (substr_count($line, '=')) {
            return explode('=', $line);
        } else {
            throw new InvalidSyntaxException("Variable without equal sign");
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
    protected function setEnvVariable($name, $value, $overwritten) {
        if ($this->checkChangingPossibility($name, $overwritten)) {
            $value = Parser::parseValue($value);
            putenv("$name=$value");
            $_SERVER[$name] = $value;
            $_ENV[$name]    = $value;
        }
        return;
    }
}