<?php

namespace SebastiaanLuca\PipeOperator\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use SebastiaanLuca\PipeOperator\Item;

class CustomIdentifierTest extends TestCase
{
    /**
     * @test
     */
    public function a custom identifier can be set using the shorthand method() : void
    {
        $this->assertSame(
            'key',
            take(['key' => 'value'], '%')
                ->pipe('array_search', 'value', '%')
                ->get()
        );
    }

    /**
     * @test
     */
    public function a custom identifier can be set from the constructor() : void
    {
        $this->assertSame(
            'key',
            (new Item(['key' => 'value'], '%'))
                ->array_search('value', '%')
                ->get()
        );
    }
}
