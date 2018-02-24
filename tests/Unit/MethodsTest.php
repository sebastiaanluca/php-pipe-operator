<?php

namespace SebastiaanLuca\PipeOperator\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;

class MethodsTest extends TestCase
{
    /**
     * @test
     */
    public function it can transform a value using a callable string method() : void
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
    public function it can transform a value using a callable string method using the method directly() : void
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
    public function it can transform a value using a closure() : void
    {
        $this->assertSame(
            'prefixed-string',
            take('string')
                ->pipe(function (string $value) {
                    return 'prefixed-' . $value;
                })
                ->get()
        );
    }

    /**
     * @test
     */
    public function it can transform a value while accepting pipe parameters() : void
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
    public function it can transform a value while accepting pipe parameters using the method directly() : void
    {
        $this->assertSame(
            ['KEY' => 'value'],
            take(['key' => 'value'])
                ->array_change_key_case(CASE_UPPER)
                ->get()
        );
    }
}
