<?php

use PHPUnit\Framework\TestCase;
use Sinevia\BusinessRule;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class BusinessRuleTest extends TestCase{

    const VALID_AGE = 10;

    public function testBusinessRule(){

        $rule = (new BusinessRule())->context(["age" => 14])->condition(function($context) { 
            $age = $context['age'] ?? -1;
            return $age > 0 && $age < 18; 
        });
        
        $this->assertTrue($rule->passes());
        $this->assertFalse($rule->fails());
    }

    public function testBusinessRuleWithExtendedClass(){

        //Test if user role == admin function should return true
        $validContext = ['user' => ["role" => "admin"]];
        assertTrue(AllowAccessRule::init($validContext)->passes(),"Error: FUNCTION (init) not work correctly");

        //Test if user role != admin function should return false
        $notValidContext = ['user' => ["role" => "user"]];
        assertTrue(AllowAccessRule::init($notValidContext)->fails(),"Error: FUNCTION (init) not work correctly");

    }

    public function testBusinessRuleWithOverride(){

        //Test if user role == admin function should return true
        $validContext = ['user' => ["role" => "admin"]];
        assertTrue(AllowAccessRuleWithOverride::init($validContext)->passes(),"Error: FUNCTION (init) not work correctly");

        //Test if user role != admin function should return false
        $notValidContext = ['user' => ["role" => "user"]];
        assertTrue(AllowAccessRuleWithOverride::init($notValidContext)->fails(),"Error: FUNCTION (init) not work correctly");

    }
}

class AllowAccessRule extends BusinessRule {
    function __construct() {
        $this->condition(function($context){
            return ($context['user']["role"] == "admin");
        });
    }
}

class AllowAccessRuleWithOverride extends BusinessRule {
    function evaluate() {
        return ($this->context['user']["role"] == "admin");
    }
}