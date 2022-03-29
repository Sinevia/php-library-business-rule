<?php

use Sinevia\BusinessRule;

$isAgeValid = function($age) { return $age > 0 && $age < 140; };

$context = ["user" => ["isAgeValid" => $isAgeValid]];

$rule = (new BusinessRule())->context($context)->condition(function($context){ return $context["user"]["isAgeValid"](10); });

var_dump($rule->evaluate());

