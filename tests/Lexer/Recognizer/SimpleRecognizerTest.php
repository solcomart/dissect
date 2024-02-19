<?php

declare(strict_types=1);

namespace Dissect\Lexer\Recognizer;

use PHPUnit\Framework\TestCase;

class SimpleRecognizerTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function recognizerShouldMatchAndPassTheValueByReference(): void
    {
        $recognizer = new SimpleRecognizer('class');
        $result = $recognizer->match('class lorem ipsum', $value);

        $this->assertTrue($result);
        $this->assertNotNull($value);
        $this->assertSame('class', $value);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function recognizerShouldFailAndTheValueShouldStayNull(): void
    {
        $recognizer = new SimpleRecognizer('class');
        $result = $recognizer->match('lorem ipsum', $value);

        $this->assertFalse($result);
        $this->assertNull($value);
    }
}
