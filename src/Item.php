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
     * @param callable|string|object $callback
     * @param array ...$arguments
     *
     * @return \SebastiaanLuca\PipeOperator\Item|\SebastiaanLuca\PipeOperator\PipeProxy
     */
    public function pipe($callback, ...$arguments)
    {
        if (! is_callable($callback)) {
            return new PipeProxy($this, $callback);
        }

        // Call the piped method
        $this->value = $callback(...$this->addValueToArguments($arguments));

        // Allow method chaining
        return $this;
    }

    /**
     * Add the given value to the list of arguments.
     *
     * @param  array $arguments
     *
     * @return array
     */
    public function addValueToArguments(array $arguments) : array
    {
        // If the caller hasn't explicitly specified where they want the value
        // to be added, we will add it as the first value. Otherwise we will
        // replace all occurrences of PIPED_VALUE with the original value.

        if (! in_array(PIPED_VALUE, $arguments, true)) {
            return array_merge([$this->value], $arguments);
        }

        return array_map(function ($argument) {
            return $argument === PIPED_VALUE ? $this->value : $argument;
        }, $arguments);
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
