<?php

use SebastiaanLuca\PipeOperator\Pipe;

if (! function_exists('take')) {
    /**
     * Create a new piped item from a given value.
     */
    function take(mixed $value): Pipe
    {
        return new Pipe($value);
    }
}
