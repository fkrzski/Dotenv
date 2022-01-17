<?php

namespace Dotenv;

use Exception;

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
     * @param string $fileName
     * @param string $path
     */
    public function __construct($fileName, $path) {
        $this->fileName = $fileName;
        $this->path     = $path;
    }

    /**
     * Load variables from .env file
     * 
     * @return void
     */
    public function load() {
        $file = $this->checkFile();
        foreach ($file as $lines => $line) {
            if ($line != "\n") {
                $data = $this->parseLine($line);
                $this->setEnvVariable($data[0], $data[1]);
            }
        }
    }


    /**
     * Check if file is file, exists and and if path is readable
     * 
     * @throws \Exception
     * 
     * @return mixed
     */
    protected function checkFile() {
        if (!is_readable($this->path.$this->fileName) && !is_file($this->path.$this->fileName) && !file_exists($this->path.$this->fileName)) {
            throw new Exception("File ".$this->path.$this->fileName." don't exists");
        } 
        return file($this->path.$this->fileName, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
    }

    public function parseLine($line) {
        return explode('=', $line);
    }

    /**
     * Check if a variable exists so as not to overwrite its value
     * 
     * @param string $name
     * 
     * @return bool
     */
    protected function checkIfEnvVariableExists($name) {
        if (array_key_exists($name, $_SERVER) || array_key_exists($name, $_SERVER) || getenv($name) != null) {
            return true;
        }
        return false;
    }

    /**
     * Set variable to getenv() function
     * 
     * @param string $name
     * @param string $value
     * 
     * @return void
     */
    protected function setEnvVariable($name, $value) {
        if (!$this->checkIfEnvVariableExists($name)) {
            putenv("$name=$value");
            $_SERVER[$name] = $value;
            $_ENV[$name]    = $value;
        }
        return;
    }
}