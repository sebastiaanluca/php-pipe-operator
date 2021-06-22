<?php

namespace SebastiaanLuca\PipeOperator\Tests\Unit\Classes;

use Closure;
use PHPUnit\Framework\TestCase;
use SebastiaanLuca\PipeOperator\Item;

class MethodsTest extends TestCase
{
    /**
     * @test
     */
    public function it can transform using the static constructor(): void
    {
        $result = Item::from('https://blog.github.com')
            ->parse_url()
            ->end()
            ->explode('.', PIPED_VALUE)
            ->reset()
            ->get();

        $this->assertSame('blog', $result);
    }

    /**
     * @test
     */
    public function it can transform a value using a callable string method(): void
    {
        $this->assertSame(
            'STRING',
            take('string')
                ->pipe('strtoupper')
                ->get()
        );
    }

    /**
     * @test
     */
    public function it can transform a value using a callable string method using the method directly(): void
    {
        $this->assertSame(
            'STRING',
            take('string')
                ->strtoupper()
                ->get()
        );
    }

    /**
     * @test
     */
    public function it can transform a value using a closure(): void
    {
        $this->assertSame(
            'prefixed-string',
            take('string')
                ->pipe(function (string $value) {
                    return 'prefixed-'.$value;
                })
                ->get()
        );
    }

    /**
     * @test
     */
    public function it can transform a value using a short closure(): void
    {
        $this->assertSame(
            'prefixed-string',
            take('string')
                ->pipe(fn (string $value): string => 'prefixed-'.$value)
                ->get()
        );
    }

    /**
     * @test
     */
    public function it can transform a value using a public class method(): void
    {
        $this->assertSame(
            'UPPERCASE',
            take('uppercase')
                ->pipe([$this, 'uppercase'])
                ->get()
        );
    }

    /**
     * @test
     */
    public function it can transform a value using a proxied public class method(): void
    {
        $this->assertSame(
            'UPPERCASE',
            take('uppercase')
                ->pipe($this)->uppercase()
                ->get()
        );
    }

    /**
     * @test
     */
    public function it can transform a value using a private class method(): void
    {
        $this->assertSame(
            'lowercase',
            take('LOWERCASE')
                ->pipe(Closure::fromCallable([$this, 'lowercase']))
                ->get()
        );
    }

    /**
     * @test
     */
    public function it can transform a value using a proxied private class method(): void
    {
        $this->assertSame(
            'start-add-this',
            take('START')
                ->pipe($this)->join('ADD', 'this')
                ->pipe($this)->lowercase()
                ->get()
        );
    }

    /**
     * @test
     */
    public function it can transform a value while accepting pipe parameters(): void
    {
        $this->assertSame(
            ['KEY' => 'value'],
            take(['key' => 'value'])
                ->pipe('array_change_key_case', CASE_UPPER)
                ->get()
        );
    }

    /**
     * @test
     */
    public function it can transform a value while accepting pipe parameters using the method directly(): void
    {
        $this->assertSame(
            ['KEY' => 'value'],
            take(['key' => 'value'])
                ->array_change_key_case(CASE_UPPER)
                ->get()
        );
    }

    public function uppercase(string $value): string
    {
        return mb_strtoupper($value);
    }

    private function lowercase(string $value): string
    {
        return mb_strtolower($value);
    }

    private function join(string ...$values): string
    {
        return implode('-', $values);
    }
}
