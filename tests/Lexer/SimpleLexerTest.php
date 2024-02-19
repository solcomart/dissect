<?php

declare(strict_types=1);

namespace Dissect\Lexer;

use PHPUnit\Framework\TestCase;

class SimpleLexerTest extends TestCase
{
    protected SimpleLexer $lexer;

    public function setUp(): void
    {
        $this->lexer = new SimpleLexer();

        $this->lexer
            ->token('A', 'a')
            ->token('(')
            ->token('B', 'b')
            ->token(')')
            ->token('C', 'c')
            ->regex('WS', "/[ \n\t\r]+/")

            ->skip('WS');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function simpleLexerShouldWalkThroughTheRecognizers(): void
    {
        $stream = $this->lexer->lex('a (b) c');

        $this->assertSame(6, $stream->count()); // with EOF
        $this->assertSame('(', $stream->get(1)->getType());
        $this->assertSame(1, $stream->get(3)->getLine());
        $this->assertSame('C', $stream->get(4)->getType());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function simpleLexerShouldSkipSpecifiedTokens(): void
    {
        $stream = $this->lexer->lex('a (b) c');

        foreach ($stream as $token) {
            $this->assertNotSame('WS', $token->getType());
        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function simpleLexerShouldReturnTheBestMatch(): void
    {
        $this->lexer->token('CLASS', 'class');
        $this->lexer->regex('WORD', '/[a-z]+/');

        $stream = $this->lexer->lex('class classloremipsum');

        $this->assertSame('CLASS', $stream->getCurrentToken()->getType());
        $this->assertSame('WORD', $stream->lookAhead(1)->getType());
    }
}
