<?php

declare(strict_types=1);

namespace Dissect\Lexer;

use Dissect\Parser\Parser;
use PHPUnit\Framework\TestCase;

class RegexLexerTest extends TestCase
{
    protected StubRegexLexer $lexer;

    protected function setUp(): void
    {
        $this->lexer = new StubRegexLexer();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itShouldCallGetTypeToRetrieveTokenType(): void
    {
        $stream = $this->lexer->lex('5 + 6');

        $this->assertCount(4, $stream);
        $this->assertSame('INT', $stream->get(0)->getType());
        $this->assertSame('+', $stream->get(1)->getType());
        $this->assertSame(Parser::EOF_TOKEN_TYPE, $stream->get(3)->getType());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function itShouldTrackLineNumbers(): void
    {
        $stream = $this->lexer->lex("5\n+\n\n5");

        $this->assertSame(2, $stream->get(1)->getLine());
        $this->assertSame(4, $stream->get(2)->getLine());
    }
}
