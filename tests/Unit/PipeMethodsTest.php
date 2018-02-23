<?php

namespace SebastiaanLuca\PipeOperator\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use SebastiaanLuca\PipeOperator\Item;

class PipeMethodsTest extends TestCase
{
    /**
     * @test
     */
    public function it can transform a value using a callable string method() : void
    {
        $this->assertSame(
            'STRING',
            (new Item('string'))
                ->pipe('strtoupper')
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
            (new Item('string'))
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
            (new Item(['key' => 'value']))
                ->pipe('array_change_key_case', CASE_UPPER)
                ->get()
        );
    }
}
