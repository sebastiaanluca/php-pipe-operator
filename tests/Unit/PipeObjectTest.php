<?php

namespace SebastiaanLuca\PipeOperator\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use SebastiaanLuca\PipeOperator\Item;

class PipeObjectTest extends TestCase
{
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
