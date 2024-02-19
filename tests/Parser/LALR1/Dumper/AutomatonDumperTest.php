<?php

declare(strict_types=1);

namespace Dissect\Parser\LALR1\Dumper;

use Dissect\Parser\LALR1\Analysis\Analyzer;
use PHPUnit\Framework\TestCase;

class AutomatonDumperTest extends TestCase
{
    protected AutomatonDumper $dumper;

    protected function setUp(): void
    {
        $analyzer = new Analyzer();
        $automaton = $analyzer->analyze(new ExampleGrammar())->getAutomaton();
        $this->dumper = new AutomatonDumper($automaton);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function dumpDumpsTheEntireAutomaton(): void
    {
        $this->assertStringEqualsFile(
            __DIR__ . '/res/graphviz/automaton.dot',
            $this->dumper->dump()
        );
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function dumpStateDumpsOnlyTheSpecifiedStateAndTransitions(): void
    {
        $this->assertStringEqualsFile(
            __DIR__ . '/res/graphviz/state.dot',
            $this->dumper->dumpState(2)
        );
    }
}
