<?php
declare(strict_types=1);

require "./vendor/autoload.php";

use fkrzski\Dotenv\Dotenv;
use fkrzski\Dotenv\Exceptions\ValidationException;
use \PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertIsObject;

class ValidatorTest extends TestCase {
    /**
     * @var string
     */
    protected $envsFolder;

    /** 
     * @before 
     */
    public function setUpTest() {
        $this->envsFolder = __DIR__.'\envs\\';
    }

    public function testValidatorRuleRequired() {
        $dotenv = new Dotenv('required.env', $this->envsFolder);
        $dotenv->start();
        $this->assertEmpty($dotenv->validator()->validate([
            'REQUIRED1' => 'required',
            'REQUIRED2' => 'required',
            'REQUIRED3' => 'required',
        ]));
    }

    public function testValidatorRuleRequiredWithoutRequiredVariable() {
        $dotenv = new Dotenv('required_without_variable.env', $this->envsFolder);
        $dotenv->start();
        $this->expectException(ValidationException::class);
        $dotenv->validator()->validate([
            'REQUIRED_WITHOUT1' => 'required',
            'REQUIRED_WITHOUT2' => 'required',
            'REQUIRED_WITHOUT3' => 'required',
        ]);
    }

    public function testValidatorRuleRequiredWithEmptyValue() {
        $dotenv = new Dotenv('required_with_empty.env', $this->envsFolder);
        $dotenv->start();
        $this->expectException(ValidationException::class);
        $dotenv->validator()->validate([
            'REQUIRED_EMPTY1' => 'required',
            'REQUIRED_EMPTY2' => 'required',
            'REQUIRED_EMPTY3' => 'required',
        ]);
    }

    public function testValidatorRuleLetters() {
        $dotenv = new Dotenv('letters.env', $this->envsFolder);
        $dotenv->start();
        $this->assertEmpty($dotenv->validator()->validate([
            'LETTERS1' => 'letters',
            'LETTERS2' => 'letters',
            'LETTERS3' => 'letters',
        ]));
    }

    public function testValidatorRuleLettersIncorrect() {
        $dotenv = new Dotenv('letters_incorrect.env', $this->envsFolder);
        $dotenv->start();
        $this->expectException(ValidationException::class);
        $dotenv->validator()->validate([
            'LETTERS_INCORRECT1' => 'letters',
            'LETTERS_INCORRECT2' => 'letters',
            'LETTERS_INCORRECT3' => 'letters',
        ]);
    }

    public function testValidatorRuleAlnum() {
        $dotenv = new Dotenv('alnum.env', $this->envsFolder);
        $dotenv->start();
        $this->assertEmpty($dotenv->validator()->validate([
            'ALNUM1' => 'alnum',
            'ALNUM2' => 'alnum',
            'ALNUM3' => 'alnum',
        ]));
    }

    public function testValidatorRuleAlnumIncorrect() {
        $dotenv = new Dotenv('alnum_incorrect.env', $this->envsFolder);
        $dotenv->start();
        $this->expectException(ValidationException::class);
        $dotenv->validator()->validate([
            'ALNUM_INCORRECT1' => 'alnum',
            'ALNUM_INCORRECT2' => 'alnum',
            'ALNUM_INCORRECT3' => 'alnum',
        ]);
    }

    public function testValidatorRuleInteger() {
        $dotenv = new Dotenv('integer.env', $this->envsFolder);
        $dotenv->start();
        $this->assertEmpty($dotenv->validator()->validate([
            'INTEGER1' => 'integer',
            'INTEGER2' => 'integer',
            'INTEGER3' => 'integer',
        ]));
    }

    public function testValidatorRulIntegerncorrect() {
        $dotenv = new Dotenv('integer_incorrect.env', $this->envsFolder);
        $dotenv->start();
        $this->expectException(ValidationException::class);
        $dotenv->validator()->validate([
            'INTEGER_INCORRECT1' => 'integer',
            'INTEGER_INCORRECT2' => 'integer',
            'INTEGER_INCORRECT3' => 'integer',
        ]);
    }

    public function testValidatorRuleBoolean() {
        $dotenv = new Dotenv('boolean.env', $this->envsFolder);
        $dotenv->start();
        $this->assertEmpty($dotenv->validator()->validate([
            'BOOLEAN1' => 'boolean',
            'BOOLEAN2' => 'boolean',
            'BOOLEAN3' => 'boolean',
        ]));
    }

    public function testValidatorRuleBooleanIncorrect() {
        $dotenv = new Dotenv('boolean_incorrect.env', $this->envsFolder);
        $dotenv->start();
        $this->expectException(ValidationException::class);
        $dotenv->validator()->validate([
            'BOOLEAN_INCORRECT1' => 'boolean',
            'BOOLEAN_INCORRECT2' => 'boolean',
            'BOOLEAN_INCORRECT3' => 'boolean',
        ]);
    }

    public function testValidatorRuleFloat() {
        $dotenv = new Dotenv('float.env', $this->envsFolder);
        $dotenv->start();
        $this->assertEmpty($dotenv->validator()->validate([
            'FLOAT1' => 'float',
            'FLOAT2' => 'float',
            'FLOAT3' => 'float',
        ]));
    }

    public function testValidatorRuleFloatIncorrect() {
        $dotenv = new Dotenv('float_incorrect.env', $this->envsFolder);
        $dotenv->start();
        $this->expectException(ValidationException::class);
        $dotenv->validator()->validate([
            'FLOAT_INCORRECT1' => 'float',
            'FLOAT_INCORRECT2' => 'float',
            'FLOAT_INCORRECT3' => 'float',
        ]);
    }
}
