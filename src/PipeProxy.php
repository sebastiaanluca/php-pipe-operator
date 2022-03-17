<?php

declare(strict_types=1);

namespace SebastiaanLuca\PipeOperator;

use Closure;

class PipeProxy
{
    protected Pipe $item;
    protected object $object;

    public function __construct(Pipe $item, object $object)
    {
        $this->item = $item;
        $this->object = $object;
    }

    public function __call(string $method, array $arguments): Pipe
    {
        $callback = Closure::bind(function (...$arguments) use ($method) {
            return $this->{$method}(...$arguments);
        }, $this->object, $this->object);

        return $this->item->pipe($callback, ...$arguments);
    }
}
