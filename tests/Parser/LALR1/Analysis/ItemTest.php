<?php

declare(strict_types=1);

namespace Dissect\Parser\LALR1\Analysis;

use Dissect\Parser\Rule;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    /**
     * @test
     */
    public function getActiveComponentShouldReturnTheComponentAboutToBeEncountered(): void
    {
        $item = new Item(new Rule(1, 'A', ['a', 'b', 'c']), 1);

        $this->assertEquals('b', $item->getActiveComponent());
    }

    /**
     * @test
     */
    public function itemShouldBeAReduceItemIfAllComponentsHaveBeenEncountered(): void
    {
        $item = new Item(new Rule(1, 'A', ['a', 'b', 'c']), 1);
        $this->assertFalse($item->isReduceItem());

        $item = new Item(new Rule(1, 'A', ['a', 'b', 'c']), 3);
        $this->assertTrue($item->isReduceItem());
    }

    /**
     * @test
     */
    public function itemShouldPumpLookaheadIntoConnectedItems(): void
    {
        $item1 = new Item(new Rule(1, 'A', ['a', 'b', 'c']), 1);
        $item2 = new Item(new Rule(1, 'A', ['a', 'b', 'c']), 2);

        $item1->connect($item2);
        $item1->pump('d');

        $this->assertContains('d', $item2->getLookahead());
    }

    /**
     * @test
     */
    public function itemShouldPumpTheSameLookaheadOnlyOnce(): void
    {
        $item1 = new Item(new Rule(1, 'A', ['a', 'b', 'c']), 1);

        // Refactor item2 for phpunit 9
        $item2 = $this->getMockBuilder(Item::class)
            ->setConstructorArgs([
                new Rule(1, 'A', ['a', 'b', 'c']),
                2,
            ])
            ->getMock();

        $item2->expects($this->once())
            ->method('pump')
            ->with($this->equalTo('d'));

        $item1->connect($item2);

        $item1->pump('d');
        $item1->pump('d');
    }

    /**
     * @test
     */
    public function getUnrecognizedComponentsShouldReturnAllComponentAfterTheDottedOne(): void
    {
        $item = new Item(new Rule(1, 'A', ['a', 'b', 'c']), 1);

        $this->assertEquals(['c'], $item->getUnrecognizedComponents());
    }
}
