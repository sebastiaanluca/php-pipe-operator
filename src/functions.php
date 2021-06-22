<?php

use SebastiaanLuca\PipeOperator\Item;

if (! function_exists('take')) {
    /**
     * Create a new piped item from a given value.
     */
    function take(mixed $value): Item
    {
        return new Item($value);
    }
}
