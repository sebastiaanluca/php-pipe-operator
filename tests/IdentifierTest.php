<?php

declare(strict_types=1);

namespace SebastiaanLuca\PipeOperator\Tests;

use PHPUnit\Framework\TestCase;

class IdentifierTest extends TestCase
{
    /**
     * @test
     */
    public function it uses the identifier to replace the value(): void
    {
        $this->assertSame(
            'key',
            take(['key' => 'value'])
                ->pipe('array_search', 'value', PIPED_VALUE)
                ->get()
        );
    }

    /**
     * @test
     */
    public function it uses the identifier to replace the value using the method directly(): void
    {
        $this->assertSame(
            'key',
            take(['key' => 'value'])
                ->array_search('value', PIPED_VALUE)
                ->get()
        );
    }
}
