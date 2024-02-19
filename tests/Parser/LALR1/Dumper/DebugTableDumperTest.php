<?php

declare(strict_types=1);

namespace Dissect\Parser\LALR1\Dumper;

use Dissect\Parser\LALR1\Analysis\Analyzer;
use PHPUnit\Framework\TestCase;

class DebugTableDumperTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function itDumpsAHumanReadableParseTableWithExplainingComments(): void
    {
        $grammar = new ExampleGrammar();
        $analyzer = new Analyzer();
        $result = $analyzer->analyze($grammar);

        $dumper = new DebugTableDumper($grammar);
        $dumped = $dumper->dump($result->getParseTable());

        $this->assertStringEqualsFile(__DIR__ . '/res/table/debug.php', $dumped);
    }
}
