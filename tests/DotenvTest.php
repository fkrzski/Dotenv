<?php
declare(strict_types=1);

require "./vendor/autoload.php";

use fkrzski\Dotenv\Dotenv;
use fkrzski\Dotenv\Exceptions\FileNotFoundException;
use fkrzski\Dotenv\Exceptions\InvalidSyntaxException;
use \PHPUnit\Framework\TestCase;

class DotenvTest extends TestCase {
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

    public function testDotenvLoadFileNotFound() {
        $dotenv = new Dotenv('file/to/not/found/.env');
        $this->expectException(FileNotFoundException::class);
        $dotenv->start();
    }
    
    public function testDotenvLoadVariables() {
        $dotenv = new Dotenv($this->envsFolder.'env.env');
        $dotenv->start();
        $this->assertSame('value1', getenv('VAR1'));
        $this->assertSame('value2', getenv('VAR2'));
        $this->assertSame('value3', getenv('VAR3'));
        $this->assertSame('value4', getenv('VAR4'));
        $this->assertSame('', getenv('NULL'));
        $this->assertSame('var=value', getenv('EQUAL'));
    }
    
    public function testDotenvLoadMultipleFilesVariables() {
        $dotenv = new Dotenv($this->envsFolder.'env.env', $this->envsFolder.'env2.env');
        $dotenv->start();
        $this->assertSame('value1', getenv('VAR1'));
        $this->assertSame('2value2', getenv('2VAR2'));
    }

    public function testDotenvLoadIncorrectVariables() {
        $dotenv = new Dotenv($this->envsFolder.'env_incorrect.env');
        $this->expectException(InvalidSyntaxException::class);
        $dotenv->start();
    }

    public function testDotenvLoadIncorrectVariables2() {
        $dotenv = new Dotenv($this->envsFolder.'env_incorrect2.env');
        $this->expectException(InvalidSyntaxException::class);
        $dotenv->start();
    }

    public function testDotenvLoadIncorrectVariables3() {
        $dotenv = new Dotenv($this->envsFolder.'env_incorrect3.env');
        $this->expectException(InvalidSyntaxException::class);
        $dotenv->start();
    }

    public function testDotenvLoadOverwrittenVariable() {
        $dotenv = new Dotenv($this->envsFolder.'overwritten.env');
        $dotenv->start(['OVERWRITTEN']);
        $this->assertSame('value5', getenv('OVERWRITTEN'));
    }

    public function testDotenvLoadOverwrittenVariables() {
        $dotenv = new Dotenv($this->envsFolder.'overwritten_all.env');
        $dotenv->start(['*']);
        $this->assertSame('value5', getenv('OVERWRITTEN_ALL'));
        $this->assertSame('value52', getenv('OVERWRITTEN_ALL2'));
    }

    public function testDotenvLoadOverwrittenNotAllowedVariable() {
        $dotenv = new Dotenv($this->envsFolder.'overwritten_not.env');
        $dotenv->start();
        $this->assertSame('value1', getenv('NOTOVERWRITTEN'));
    }

    public function testDotenvLoadUnquotedVariables() {
        $dotenv = new Dotenv($this->envsFolder.'unquoted.env');
        $dotenv->start();
        $this->assertSame('', getenv('uNULL'));
        $this->assertSame('string', getenv('uSTRING'));
        $this->assertSame('true', getenv('uBOOL'));
        $this->assertSame('1', getenv('uINT'));
        $this->assertSame('1.1', getenv('uFLOAT'));
        $this->assertSame('a', getenv('uCHAR'));
    }

    public function testDotenvLoadQuotedVariables() {
        $dotenv = new Dotenv($this->envsFolder.'quoted.env');
        $dotenv->start();
        $this->assertSame('', getenv('qNULL'));
        $this->assertSame('string', getenv('qSTRING'));
        $this->assertSame('true', getenv('qBOOL'));
        $this->assertSame('1', getenv('qINT'));
        $this->assertSame('1.1', getenv('qFLOAT'));
        $this->assertSame('a', getenv('qCHAR'));
        $this->assertSame('var=value', getenv('qEQUAL'));
    }

    public function testDotenvLoadIncorrectQuotedVariables() {
        $dotenv = new Dotenv($this->envsFolder.'quoted_incorrect.env');
        $this->expectException(InvalidSyntaxException::class);
        $dotenv->start();
    }

    public function testDotenvLoadSingleQuotedVariables() {
        $dotenv = new Dotenv($this->envsFolder.'squoted.env');
        $dotenv->start();
        $this->assertSame('value', getenv('sQUOTED1'));
        $this->assertSame('va=lue', getenv('sQUOTED2'));
        $this->assertSame('value #comment', getenv('sQUOTED3'));
    }

    public function testDotenvLoadIncorrectSingleQuotedVariables() {
        $dotenv = new Dotenv($this->envsFolder.'squoted_incorrect.env');
        $this->expectException(InvalidSyntaxException::class);
        $dotenv->start();
    }

    public function testDotenvLoadCommentedVariables() {
        $dotenv = new Dotenv($this->envsFolder.'commented.env');
        $dotenv->start();
        $this->assertSame('value1', getenv('cVAR1'));
        $this->assertSame('value2 # comment', getenv('cVAR2'));
        $this->assertSame('', getenv('cVAR3'));
        $this->assertSame('value 4', getenv('cVAR4'));
    }

    public function testDotenvLoadIncorrectCommentedVariables() {
        $dotenv = new Dotenv($this->envsFolder.'commented_incorrect.env');
        $this->expectException(InvalidSyntaxException::class);
        $dotenv->start();
    }

    public function testDotenvLoadVariablesWithSpaces() {
        $dotenv = new Dotenv($this->envsFolder.'spaces.env');
        $dotenv->start();
        $this->assertSame('with space', getenv('WITH_SPACE'));
        $this->assertSame('with more spcaces ! ! !', getenv('WITH_SPACES'));
    }

    public function testDotenvLoadVariablesWithIncorrectSpaces() {
        $dotenv = new Dotenv($this->envsFolder.'spaces_incorrect.env');
        $this->expectException(InvalidSyntaxException::class);
        $dotenv->start();
    }

    public function testDotenvLoadSingleVariable() {
        Dotenv::single('SINGLE_NAME', 'SINGLE_VALUE');
        $this->assertSame('SINGLE_VALUE', getenv('SINGLE_NAME'));
    }

    public function testDotenvLoadSingleVariableWithOverwrite() {
        Dotenv::single('SINGLE_NAME_OVERWRITTEN', 'SINGLE_VALUE');
        Dotenv::single('SINGLE_NAME_OVERWRITTEN', 'SINGLE_VALUE_OVERWRITTEN', true);
        $this->assertSame('SINGLE_VALUE_OVERWRITTEN', getenv('SINGLE_NAME_OVERWRITTEN'));
    }

    public function testDotenvLoadSingleVariableWithBadOverwrite() {
        Dotenv::single('SINGLE_NAME_BAD_OVERWRITTEN', 'SINGLE_VALUE');
        Dotenv::single('SINGLE_NAME_BAD_OVERWRITTEN', 'SINGLE_VALUE_BAD_OVERWRITTEN', false);
        $this->assertSame('SINGLE_VALUE', getenv('SINGLE_NAME_BAD_OVERWRITTEN'));
    }
}