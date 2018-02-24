<?php

namespace SebastiaanLuca\PipeOperator\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;

class IdentifierTest extends TestCase
{
    /**
     * @test
     */
    public function it uses the default identifier to replace the value() : void
    {
        $this->assertSame(
            'key',
            take(['key' => 'value'])
                ->pipe('array_search', 'value', '$$')
                ->get()
        );
    }

    /**
     * @test
     */
    public function it uses the default identifier to replace the value using the method directly() : void
    {
        $this->assertSame(
            'key',
            take(['key' => 'value'])
                ->array_search('value', '$$')
                ->get()
        );
    }
}
