<?php

namespace Dotenv;

class Dotenv {
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
     * Loader instance
     * 
     * @var \Dotenv\Loader
     */
    protected $loader;

    /**
     * Create a new Dotenv instance
     * 
     * @param string $fileName The name of the file with the environment variables
     * @param string $path     Path to the file with the environment variables
     * 
     * @return void
     */
    public function __construct($fileName = '.env', $path = '') {
        $this->fileName = $fileName;
        $this->path     = $path;
        $this->loader   = new Loader($this->fileName, $this->path);
    }

    /**
     * Run a Dotenv instance and load variables 
     * 
     * @param array $overwritten Variables names that can be overwritten
     *
     * @return void
     */
    public function start(array $overwritten = []) {
        return $this->loader->load($overwritten);
    }

    /**
     * Return new Validtor instance to validate data from .env
     * 
     * @return \Dotenv\Validator 
     */
    public function validator() {
        return new Validator();
    }
}