<?php

declare(strict_types=1);

namespace SebastiaanLuca\PipeOperator\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use SebastiaanLuca\PipeOperator\Pipe;

class ObjectTest extends TestCase
{
    /**
     * @test
     */
    public function it returns an item object when get has not been called yet(): void
    {
        $this->assertInstanceOf(
            Pipe::class,
            take('string')->pipe('strtoupper')
        );
    }

    /**
     * @test
     */
    public function it returns an item object when get has not been called yet using the method directly(): void
    {
        $this->assertInstanceOf(
            Pipe::class,
            take('string')->strtoupper()
        );
    }

    /**
     * @test
     */
    public function it can transform a complex value in multiple steps(): void
    {
        $this->assertSame(
            'blog',
            take('https://blog.sebastiaanluca.com')
                ->pipe('parse_url')
                ->pipe('end')
                ->pipe('explode', '.', PIPED_VALUE)
                ->pipe('reset')
                ->get()
        );
    }

    /**
     * @test
     */
    public function it can transform a complex value in multiple steps using the method directly(): void
    {
        $this->assertSame(
            'blog',
            take('https://blog.sebastiaanluca.com')
                ->parse_url(PHP_URL_HOST)
                ->explode('.', PIPED_VALUE)
                ->reset()
                ->get()
        );
    }

    /**
     * @test
     */
    public function it can transform a complex value in multiple steps using different method calls(): void
    {
        $this->assertSame(
            'blog',
            take('https://blog.sebastiaanluca.com')
                ->pipe('parse_url')
                ->end()
                ->explode('.', PIPED_VALUE)
                ->pipe('reset')
                ->get()
        );
    }
}
