<?php

namespace Tests\Sender\Phone;

use \laravel\pagseguro\Sender\Phone\ValidationRules;

/**
 * Sender Phone Validation Test
 * @author Isaque de Souza <isaquesb@gmail.com>
 */
class ValidationRulesTest extends \Tests\ValidationRules
{

    /**
     * @param string $key
     * @return mixed
     */
    protected function getRule($key)
    {
        if(!$this->rules) {
            $o = new ValidationRules();
            $this->rules = $o->getRules();
        }
        return $this->rules[$key];
    }

    /**
     * Area Code Data Provider
     * @return array
     */
    public function areaCodeProvider()
    {
        return [
            ['', false],
            ['32', true],
            [44, true],
            [11, true],
            [110, false],
            [1, false],
            ['9', false],
        ];
    }

    /**
     * Phone Data Provider
     * @return array
     */
    public function phoneProvider()
    {
        return [
            ['', false],
            ['987654321', true],
            ['9876543210', false],
            [87654321, true],
            ['8765432', false],
            ['phone123456789', false],
        ];
    }

    /**
     * @dataProvider areaCodeProvider
     * @param mixed $value
     * @param boolean $expected
     * @return array
     */
    public function testAreaCode($value, $expected)
    {
        $rule = $this->getRule('senderAreaCode');
        $v = $this->validatorMake($rule, $value);
        $this->assertEquals($expected, $v->passes());
    }

    /**
     * @dataProvider phoneProvider
     * @param mixed $value
     * @param boolean $expected
     * @return array
     */
    public function testPhone($value, $expected)
    {
        $rule = $this->getRule('senderPhone');
        $v = $this->validatorMake($rule, $value);
        $this->assertEquals($expected, $v->passes());
    }
}
