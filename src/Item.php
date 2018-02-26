<?php

namespace SebastiaanLuca\PipeOperator;

class Item
{
    /**
     * The current value being handled.
     *
     * @var mixed
     */
    protected $value;

    /**
     * @param mixed $value The value you want to process.
     */
    public function __construct($value)
    {
        $this->value = $value;

        if (! defined('PIPED_VALUE')) {
            define('PIPED_VALUE', 'PIPED_VALUE-' . uniqid());
        }
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->pipe($name, ...$arguments);
    }

    /**
     * Perform an operation on the current value.
     *
     * @param callable|string $callback
     * @param array ...$arguments
     *
     * @return \SebastiaanLuca\PipeOperator\Item $this
     */
    public function pipe($callback, ...$arguments)
    {
        // No explicit use of the value identifier means it should be the first
        //argument to call the method with. If it does get used though, we should
        // replace any occurrence of it with the actual value.

        if (! in_array(PIPED_VALUE, $arguments, true)) {
            // Add the given item value as first parameter to call the pipe method with
            array_unshift($arguments, $this->value);
        }
        else {
            $arguments = array_map(function ($argument) {
                return $argument === PIPED_VALUE ? $this->value : $argument;
            }, $arguments);
        }

        // Call the piped method
        $this->value = $callback(...$arguments);

        // Allow method chaining
        return $this;
    }

    /**
     * Get the current value.
     *
     * @return mixed
     */
    public function get()
    {
        return $this->value;
    }
}
