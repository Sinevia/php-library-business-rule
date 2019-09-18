# PHP Library Business Rule #

A business rule defines or constrains some aspect of business. Given a specified context (data) a business rule always resolves to either true or false.

Formal specification:
// Given <Context> When <condition(s)> Then <Pass> Or <Fail>

## Usage ##

1) Directl usage
```
$rule = (new BusinessRule())->context([])->condition(function($context){ return true; });

if ($rule->fails()) {
    // Execute fail logic
}

if ($rule->passes()) {
    // Execute pass logic
}
```

2) Extend into a separate class. Allows to be re-used (avoid duplication of business logic)

```
class AllowAccessRule extends BusinessRule {
    function __construct() {
        $this->condition(function($context){
            return ($context['user']->isEmailConfirmed() AND $context['user']->isActive());
        });
    }
}

if (AllowAccessRule::init(['user'=>$user)->fails()) {
    die('You are not allowed access to this part of the website');
}
```
