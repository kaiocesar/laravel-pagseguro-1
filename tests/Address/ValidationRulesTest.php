<?php

use \laravel\pagseguro\Address\ValidationRules;

/**
 * Address Validation Test
 * @author Isaque de Souza <isaquesb@gmail.com>
 */
class ValidationRulesTest extends PHPUnit_Framework_TestCase
{

    protected $rules;

    protected function validatorMake($rule, $value)
    {
        return new \Illuminate\Validation\Validator(
            new \Symfony\Component\Translation\Translator('pt_BR'),
            ['field' => $value],
            ['field' => $rule]
        );
    }

    protected function getRule($key)
    {
        if(!$this->rules) {
            $o = new ValidationRules();
            $this->rules = $o->getRules();
        }
        return $this->rules[$key];
    }

    public function postalCodeProvider()
    {
        return [
            ['', false],
            ['asdasd', false],
            ['0640512', false],
            ['06405122', true],
            ['064051228', false],
        ];
    }

    /**
     * @dataProvider postalCodeProvider
     * @param mixed $value
     * @param mixed $expected
     * @return array
     */
    public function testPostalCode($value, $expected)
    {
        $rule = $this->getRule('postalCode');
        $v = $this->validatorMake($rule, $value);
        $this->assertEquals($expected, $v->passes());
    }

    public function streetProvider()
    {
        return [
            ['', false],
            ['NOME DA RUA', true],
            [str_repeat('NOME RUA', 10), true],
            [str_repeat('NOME RUA', 10) . 'A', false],
        ];
    }

    /**
     * @dataProvider streetProvider
     * @param mixed $value
     * @param mixed $expected
     * @return array
     */
    public function testStreet($value, $expected)
    {
        $rule = $this->getRule('street');
        $v = $this->validatorMake($rule, $value);
        $this->assertEquals($expected, $v->passes());
    }

    public function complementProvider()
    {
        return [
            ['', true],
            ['Number 43', true],
            [str_repeat('COMP', 10), true],
            [str_repeat('COMP', 10) . 'A', false],
        ];
    }

    /**
     * @dataProvider complementProvider
     * @param mixed $value
     * @param mixed $expected
     * @return array
     */
    public function testComplement($value, $expected)
    {
        $rule = $this->getRule('complement');
        $v = $this->validatorMake($rule, $value);
        $this->assertEquals($expected, $v->passes());
    }

    public function districtProvider()
    {
        return [
            ['', false],
            ['DISTCT NAME', true],
            [str_repeat('DISTCT', 10), true],
            [str_repeat('DISTCT', 10) . 'A', false],
        ];
    }

    /**
     * @dataProvider districtProvider
     * @param mixed $value
     * @param mixed $expected
     * @return array
     */
    public function testDistrict($value, $expected)
    {
        $rule = $this->getRule('district');
        $v = $this->validatorMake($rule, $value);
        $this->assertEquals($expected, $v->passes());
    }

    public function cityProvider()
    {
        return [
            ['', false],
            ['CITY NAME', true],
            ['C', false],
            [str_repeat('CITYNM', 10), true],
            [str_repeat('CITYNM', 10) . 'A', false],
        ];
    }

    /**
     * @dataProvider cityProvider
     * @param mixed $value
     * @param mixed $expected
     * @return array
     */
    public function testCity($value, $expected)
    {
        $rule = $this->getRule('city');
        $v = $this->validatorMake($rule, $value);
        $this->assertEquals($expected, $v->passes());
    }

    public function stateProvider()
    {
        return [
            ['', false],
            ['SP', true],
            ['STATE', false],
        ];
    }

    /**
     * @dataProvider stateProvider
     * @param mixed $value
     * @param mixed $expected
     * @return array
     */
    public function testState($value, $expected)
    {
        $rule = $this->getRule('state');
        $v = $this->validatorMake($rule, $value);
        $this->assertEquals($expected, $v->passes());
    }

    public function countryProvider()
    {
        return [
            ['', false],
            ['BRA', true],
            ['ARG', false],
        ];
    }

    /**
     * @dataProvider countryProvider
     * @param mixed $value
     * @param mixed $expected
     * @return array
     */
    public function countryState($value, $expected)
    {
        $rule = $this->getRule('country');
        $v = $this->validatorMake($rule, $value);
        $this->assertEquals($expected, $v->passes());
    }
}