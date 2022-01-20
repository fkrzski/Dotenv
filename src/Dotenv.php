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
     * Create new Dotenv instance
     * 
     * @param string $fileName
     * @param string $path
     * 
     * @return void
     */
    public function __construct($fileName = '.env', $path = '') {
        $this->fileName = $fileName;
        $this->path     = $path;
        $this->loader   = new Loader($this->fileName, $this->path);
    }

    /**
     * Run Dotenv instance and load variables 
     *
     * @return void
     */
    public function start() {
        return $this->loader->load();
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