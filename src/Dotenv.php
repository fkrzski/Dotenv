<?php
declare(strict_types=1);

namespace fkrzski\Dotenv;

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

    /**
     * Put or edit one environment variable 
     * 
     * @param string $name        The name of the new variable
     * @param string $value       The value of the new variable
     * @param array  $overwritten Variables names that can be overwritten
     * 
     * @return mixed
     */
    public static function single($name, $value, $overwritten = false) {
        Parser::checkName($name);
        $value = Parser::parseValue($value);

        if ($overwritten == true) {
            $overwritten = array($name);
        } else {
            $overwritten = [];
        }

        $loader = new Loader('', '');
        return $loader->setEnvVariable($name, $value, $overwritten);
    }
}