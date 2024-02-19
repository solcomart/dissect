<?php

declare(strict_types=1);

namespace Dissect\Parser\LALR1\Dumper;

use Dissect\Parser\LALR1\Analysis\Analyzer;
use PHPUnit\Framework\TestCase;

class ProductionTableDumperTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function theWrittenTableShouldBeAsCompactAsPossible(): void
    {
        $grammar = new ExampleGrammar();
        $analyzer = new Analyzer();
        $table = $analyzer->analyze($grammar)->getParseTable();

        $dumper = new ProductionTableDumper();
        $dumped = $dumper->dump($table);

        $this->assertStringEqualsFile(__DIR__ . '/res/table/production.php', $dumped);
    }
}
