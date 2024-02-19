<?php

declare(strict_types=1);

namespace Dissect\Lexer\Recognizer;

use PHPUnit\Framework\TestCase;

class RegexRecognizerTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function recognizerShouldMatchAndPassTheValueByReference(): void
    {
        $recognizer = new RegexRecognizer('/[a-z]+/');
        $result = $recognizer->match('lorem ipsum', $value);

        $this->assertTrue($result);
        $this->assertNotNull($value);
        $this->assertSame('lorem', $value);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function recognizerShouldFailAndTheValueShouldStayNull(): void
    {
        $recognizer = new RegexRecognizer('/[a-z]+/');
        $result = $recognizer->match('123 456', $value);

        $this->assertFalse($result);
        $this->assertNull($value);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function recognizerShouldFailIfTheMatchIsNotAtTheBeginningOfTheString(): void
    {
        $recognizer = new RegexRecognizer('/[a-z]+/');
        $result = $recognizer->match('234 class', $value);

        $this->assertFalse($result);
        $this->assertNull($value);
    }
}
