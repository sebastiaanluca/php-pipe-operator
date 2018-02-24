<?php

namespace SebastiaanLuca\PipeOperator\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use SebastiaanLuca\PipeOperator\Item;

class PipeIdentifierTest extends TestCase
{
    /**
     * @test
     */
    public function it uses the default identifier to replace the value() : void
    {
        $this->assertSame(
            'key',
            (new Item(['key' => 'value']))
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
            (new Item(['key' => 'value']))
                ->array_search('value', '$$')
                ->get()
        );
    }

    /**
     * @test
     */
    public function it uses the custom identifier to replace the value() : void
    {
        $this->assertSame(
            'The meaning of everything is to make everything be more.',
            (new ExtendedItem('The meaning of life is to make life be more.'))
                ->pipe('str_replace', 'life', 'everything', '42')
                ->get()
        );
    }

    /**
     * @test
     */
    public function it uses the custom identifier to replace the value using the method directly() : void
    {
        $this->assertSame(
            'The meaning of everything is to make everything be more.',
            (new ExtendedItem('The meaning of life is to make life be more.'))
                ->str_replace('life', 'everything', '42')
                ->get()
        );
    }
}

class ExtendedItem extends Item
{
    protected $identifier = '42';
}
