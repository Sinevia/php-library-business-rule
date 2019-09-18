<?php

namespace Sinevia;

class BusinessRule
{
    /**
     * Context (data) for the rule
     */
    public $context = [];

    /**
     * Callback for condition
     */
    private $conditionCallback = null;

    /**
     * Shortcut to initialize the rule with context
     */
    public static function init($context = [])
    {
        $o = new static;
        $o->context($context);
        return $o;
    }

    /**
     * Sets the context for the rule
     */
    public function context($context)
    {
        $this->context = $context;
        return $this;
    }

    /**
     * Sets the condition for the rule
     */
    public function condition($conditionCallback)
    {
        $this->conditionCallback = $conditionCallback;
        return $this;
    }

    /**
     * Returns true if the rule evaluates to false
     * @return boolean
     */
    public function fails()
    {
        return ($this->evaluate() == false);
    }

    /**
     * Returns true if the rule evaluates to true
     * @return boolean
     */
    public function passes()
    {
        return ($this->evaluate() == true);
    }

    /**
     * Evauates the condition and returns the result
     */
    public function evaluate()
    {
        return call_user_func($this->conditionCallback, $this->context);
    }
}
