<?php

declare(strict_types=1);

namespace Dissect\Parser;

use PHPUnit\Framework\TestCase;

class GrammarTest extends TestCase
{
    protected ExampleGrammar $grammar;

    protected function setUp(): void
    {
        $this->grammar = new ExampleGrammar();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function ruleAlternativesShouldHaveTheSameName(): void
    {
        $rules = $this->grammar->getRules();

        $this->assertSame('Foo', $rules[1]->getName());
        $this->assertSame('Foo', $rules[2]->getName());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function theGrammarShouldBeAugmentedWithAStartRule(): void
    {
        $this->assertSame(
            Grammar::START_RULE_NAME,
            $this->grammar->getStartRule()->getName()
        );

        $this->assertSame(
            array('Foo'),
            $this->grammar->getStartRule()->getComponents()
        );
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function shouldReturnAlternativesGroupedByName(): void
    {
        $rules = $this->grammar->getGroupedRules();
        $this->assertCount(2, $rules['Foo']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function nonterminalsShouldBeDetectedFromRuleNames(): void
    {
        $this->assertTrue($this->grammar->hasNonterminal('Foo'));
    }
}
