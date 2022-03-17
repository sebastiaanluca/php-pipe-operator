<?php

declare(strict_types=1);

namespace SebastiaanLuca\PipeOperator;

class Pipe
{
    protected mixed $value;

    public function __construct(mixed $value)
    {
        $this->value = $value;

        if (! defined('PIPED_VALUE')) {
            define('PIPED_VALUE', 'PIPED_VALUE-'.uniqid('', true));
        }
    }

    public function __call(string $name, array $arguments): mixed
    {
        return $this->pipe($name, ...$arguments);
    }

    public static function from($value): self
    {
        return new self($value);
    }

    public function pipe(callable|object|string $callback, mixed ...$arguments): self|PipeProxy
    {
        if (! is_callable($callback)) {
            return new PipeProxy($this, $callback);
        }

        // Call the piped method
        $this->value = $callback(...$this->addValueToArguments($arguments));

        // Allow method chaining
        return $this;
    }

    public function addValueToArguments(array $arguments): array
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

    public function get(): mixed
    {
        return $this->value;
    }
}
