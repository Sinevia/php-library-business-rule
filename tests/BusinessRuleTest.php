<?php

use PHPUnit\Framework\TestCase;
use Sinevia\BusinessRule;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class BusinessRuleTest extends TestCase{

    const VALID_AGE = 10;

    public function testBusinessRule(){

        $isAgeValid = function($age) { return $age > 0 && $age < 140; };

        $context = ["user" => ["isAgeValid" => $isAgeValid]];

        $rule = (new BusinessRule())->context($context)->condition(function($context){ return $context["user"]["isAgeValid"](self::VALID_AGE); });
        
        //Test evaluate function
        assertEquals($rule->evaluate(),$isAgeValid(self::VALID_AGE), "Error: FUNCTION (evaluate) not work correctly");

        //Test if rule return false
        assertFalse($rule->fails(),"Error: FUNCTION (fails) not work correctly");

        //Test if rule return true
        assertTrue($rule->passes(),"Error: FUNCTION (passes) not work correctly");

        //Test if set context work correctly
        assertEquals($context,$rule->context, "Error: context not work correctly");
        $newContext = ["test"];
        assertEquals($newContext,$rule->context($newContext)->context, "Error: FUNCTION (context)  not work correctly");

    }

    public function testBusinessRuleExtendet(){
        
        //Testing init function with this function we can reuse code

        //Test if user role == admin function should return true
        $validContext = ['user' => ["role" => "admin"]];
        assertTrue(AllowAccessRule::init($validContext)->passes(),"Error: FUNCTION (init) not work correctly");

        //Test if user role != admin function should return false
        $notValidContext = ['user' => ["role" => "user"]];
        assertTrue(AllowAccessRule::init($notValidContext)->fails(),"Error: FUNCTION (init) not work correctly");

    }
}

class AllowAccessRule extends BusinessRule {
    function __construct() {
        $this->condition(function($context){
            return ($context['user']["role"] == "admin");
        });
    }
}