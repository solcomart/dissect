<?php

declare(strict_types=1);

namespace Dissect\Parser\LALR1;

use Dissect\Parser\Exception\UnexpectedTokenException;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    protected ArithLexer $lexer;
    protected Parser $parser;

    protected function setUp(): void
    {
        $this->lexer = new ArithLexer();
        $this->parser = new Parser(new ArithGrammar());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function parserShouldProcessTheTokenStreamAndUseGrammarCallbacksForReductions(): void
    {
        $this->assertSame(-2, $this->parser->parse($this->lexer->lex(
            '-1 - 1')));

        $this->assertSame(11664, $this->parser->parse($this->lexer->lex(
            '6 ** (1 + 1) ** 2 * (5 + 4)')));

        $this->assertSame(-4, $this->parser->parse($this->lexer->lex(
            '3 - 5 - 2')));

        $this->assertSame(262144, $this->parser->parse($this->lexer->lex(
            '4 ** 3 ** 2')));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function parserShouldThrowAnExceptionOnInvalidInput(): void
    {
        try {
            $this->parser->parse($this->lexer->lex('6 ** 5 3'));
            $this->fail('Expected an UnexpectedTokenException.');
        } catch (UnexpectedTokenException $e) {
            $this->assertSame('INT', $e->getToken()->getType());
            $this->assertSame(array('$eof', '+', '-', '*', '/', '**', ')'), $e->getExpected());
            $this->assertSame(<<<EOT
Unexpected 3 (INT) at line 1.

Expected one of \$eof, +, -, *, /, **, ).
EOT
            , $e->getMessage());
        }
    }
}
