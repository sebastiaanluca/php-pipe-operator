<?php

namespace SebastiaanLuca\Helpers\Tests\Unit\Classes;

use SebastiaanLuca\Helpers\Tests\TestCase;
use SebastiaanLuca\PipeOperator\Item;

class PipeTest extends TestCase
{
    /**
     * @test
     */
    public function it can transform a value using a callable string method() : void
    {
        $this->assertSame(
            'STRING',
            (new Item('string'))->pipe('strtoupper')->get()
        );
    }

    /**
     * @test
     */
    public function it can transform a value using a closure() : void
    {
        $this->assertSame(
            'prefixed-string',
            (new Item('string'))->pipe(function (string $value) {
                return 'prefixed-' . $value;
            })->get()
        );
    }

    /**
     * @test
     */
    public function it can transform a value while accepting pipe parameters() : void
    {
        $this->assertSame(
            'value',
            (new Item(['key' => 'value']))->pipe('array_get', 'key')->get()
        );
    }

    /**
     * @test
     */
    public function it can transform a complex value in multiple steps() : void
    {
        $this->assertSame(
            'blog',
            (new Item('https://blog.sebastiaanluca.com'))
                ->pipe('parse_url')
                ->pipe('array_get', 'host')
                ->pipe('explode', '.', '$$')
                ->pipe('array_get', 0)
                ->get()
        );
    }

    /**
     * @test
     */
    public function it returns an item object when get has not been called yet() : void
    {
        $this->assertInstanceOf(Item::class, (new Item('string'))->pipe('strtoupper'));
    }

    public function test it uses the identifier to replace the actual value() : void
    {
        $this->assertSame(
            'The meaning of everything is to make everything be more.',
            (new ExtendedItem('The meaning of life is to make life be more.'))
                ->pipe('str_replace', 'life', 'everything', '42')
                ->get()
        );
    }
}

class ExtendedItem extends Item
{
    protected $identifier = '42';
}
