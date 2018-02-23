<?php

namespace SebastiaanLuca\PipeOperator\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
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

    /**
     * @test
     */
    public function it returns an item object when get has not been called yet() : void
    {
        $this->assertInstanceOf(
            Item::class,
            (new Item('string'))->pipe('strtoupper')
        );
    }

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
    public function it uses the identifier to replace the value() : void
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
    public function it can transform a complex value in multiple steps() : void
    {
        $this->assertSame(
            'blog',
            (new Item('https://blog.sebastiaanluca.com'))
                ->pipe('parse_url')
                ->pipe('end')
                ->pipe('explode', '.', '$$')
                ->pipe('reset')
                ->get()
        );
    }
}

class ExtendedItem extends Item
{
    protected $identifier = '42';
}
