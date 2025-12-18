<?php
declare(strict_types=1);

require "./vendor/autoload.php";

use fkrzski\Dotenv\Dotenv;
use fkrzski\Dotenv\Exceptions\FileNotFoundException;
use fkrzski\Dotenv\Exceptions\InvalidSyntaxException;
use \PHPUnit\Framework\TestCase;

class ExtendedDotenvTest extends TestCase {
    /**
     * @var string
     */
    protected $envsFolder;

    /** 
     * @before 
     */
    public function setUpTest() {
        $this->envsFolder = __DIR__.'/envs/';
    }

    public function testDotenvLoadEmptyValue() {
        $dotenv = new Dotenv($this->envsFolder.'empty_val.env');
        $dotenv->start();
        $this->assertSame('', getenv('EMPTY'));
    }

    public function testDotenvLoadOnlyComments() {
        $dotenv = new Dotenv($this->envsFolder.'only_comments.env');
        $dotenv->start();
        // No variables should be set, just ensure it doesn't crash
        $this->assertTrue(true);
    }

    public function testDotenvSingleWithBoolean() {
        Dotenv::single('BOOL_TRUE', 'true');
        $this->assertSame('true', getenv('BOOL_TRUE'));

        Dotenv::single('BOOL_FALSE', 'false');
        $this->assertSame('false', getenv('BOOL_FALSE'));
    }
    
    public function testDotenvSingleWithNumeric() {
        Dotenv::single('NUM_INT', '123');
        $this->assertSame('123', getenv('NUM_INT'));

        Dotenv::single('NUM_FLOAT', '12.34');
        $this->assertSame('12.34', getenv('NUM_FLOAT'));
    }

}
