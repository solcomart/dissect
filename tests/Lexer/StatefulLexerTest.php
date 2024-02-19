<?php

declare(strict_types=1);

namespace Dissect\Lexer;

use LogicException;
use PHPUnit\Framework\TestCase;

class StatefulLexerTest extends TestCase
{
    protected StatefulLexer $lexer;

    protected function setUp(): void
    {
        $this->lexer = new StatefulLexer();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function addingNewTokenShouldThrowAnExceptionWhenNoStateIsBeingBuilt(): void
    {
        $this->expectExceptionMessage("Define a lexer state first.");
        $this->expectException(LogicException::class);
        $this->lexer->regex('WORD', '/[a-z]+/');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function anExceptionShouldBeThrownOnLexingWithoutAStartingState(): void
    {
        $this->expectException(LogicException::class);
        $this->lexer->state('root');
        $this->lexer->lex('foo');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function theStateMechanismShouldCorrectlyPushAndPopStatesFromTheStack(): void
    {
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        $this->lexer->state('root')
            ->regex('WORD', '/[a-z]+/')
            ->regex('WS', "/[ \r\n\t]+/")
            ->token('"')->action('string')
            ->skip('WS');

        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        $this->lexer->state('string')
            ->regex('STRING_CONTENTS', '/(\\\\"|[^"])+/')
            ->token('"')->action(StatefulLexer::POP_STATE);

        $this->lexer->start('root');

        $stream = $this->lexer->lex('foo bar "long \\" string" baz quux');

        $this->assertCount(8, $stream);
        $this->assertSame('STRING_CONTENTS', $stream->get(3)->getType());
        $this->assertSame('long \\" string', $stream->get(3)->getValue());
        $this->assertSame('quux', $stream->get(6)->getValue());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function defaultActionShouldBeNop(): void
    {
        $this->lexer->state('root')
            ->regex('WORD', '/[a-z]+/')
            ->regex('WS', "/[ \r\n\t]+/")
            ->skip('WS');

        $this->lexer->state('string');

        $this->lexer->start('root');

        $stream = $this->lexer->lex('foo bar');
        $this->assertSame(3, $stream->count());
    }
}
