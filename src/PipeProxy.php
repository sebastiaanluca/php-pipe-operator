<?php

namespace SebastiaanLuca\PipeOperator;

use Closure;

class PipeProxy
{
    /**
     * @param \SebastiaanLuca\PipeOperator\Item $item
     * @param object $object
     */
    public function __construct(Item $item, $object)
    {
        $this->item = $item;
        $this->object = $object;
    }

    /**
     * @param string $method
     * @param array $arguments
     *
     * @return \SebastiaanLuca\PipeOperator\Item $this
     */
    public function __call($method, array $arguments)
    {
        $callback = Closure::bind(function (...$arguments) use ($method) {
            return $this->{$method}(...$arguments);
        }, $this->object, $this->object);

        return $this->item->pipe($callback, ...$arguments);
    }
}
