<?php

namespace SebastiaanLuca\PipeOperator;

use Closure;

class PipeProxy
{
    protected Item $item;
    protected object $object;

    public function __construct(Item $item, object $object)
    {
        $this->item = $item;
        $this->object = $object;
    }

    public function __call(string $method, array $arguments): Item
    {
        $callback = Closure::bind(function (...$arguments) use ($method) {
            return $this->{$method}(...$arguments);
        }, $this->object, $this->object);

        return $this->item->pipe($callback, ...$arguments);
    }
}
