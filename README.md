# PHP Library Business Rule #

![No Dependencies](https://img.shields.io/badge/no-dependencies-success.svg)
![Tests](https://github.com/Sinevia/php-library-business-rule/workflows/php/badge.svg)
[![Gitpod Ready-to-Code](https://img.shields.io/badge/Gitpod-Ready--to--Code-blue?logo=gitpod)](https://gitpod.io/#https://github.com/Sinevia/php-library-business-rule) 

A business rule defines or constrains some aspect of business. Given a specified context (data) a business rule always resolves to either true or false.

Formal specification:
// Given {context} When {condition(s)} Then {pass} Or {fail}

## Usage ##

1) Direct usage

```php
$rule = (new BusinessRule())->context([])->condition(function($context){ return true; });

if ($rule->fails()) {
    // Execute fail logic
}

if ($rule->passes()) {
    // Execute pass logic
}
```

2) Extend into a separate class. Allows to be re-used (avoid duplication of business logic)

```php

// 1. Specify the business rule class
class AllowAccessRule extends BusinessRule {
    function __construct() {
        $this->condition(function($context){
            return ($context['user']->isEmailConfirmed() AND $context['user']->isActive());
        });
    }
}

// Use the shortcut init function with the context to initialize the rule
if (AllowAccessRule::init(['user'=>$user)->fails()) {
    die('You are not allowed access to this part of the website');
}
```
