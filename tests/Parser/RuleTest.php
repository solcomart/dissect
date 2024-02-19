<?php

declare(strict_types=1);

namespace Dissect\Parser;

use PHPUnit\Framework\TestCase;

class RuleTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function getComponentShouldReturnNullIfAskedForComponentOutOfRange(): void
    {
        $r = new Rule(1, 'Foo', ['x', 'y']);
        $this->assertSame('y', $r->getComponent(1));
        $this->assertNull($r->getComponent(2));
    }
}
