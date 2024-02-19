<?php

declare(strict_types=1);

namespace Dissect\Lexer;

/**
 * A common contract for tokens.
 *
 * @author Jakub Lédl <jakubledl@gmail.com>
 */
interface Token
{
    /**
     * Returns the token type.
     */
    public function getType(): mixed;

    /**
     * Returns the token value.
     */
    public function getValue(): int|string;

    /**
     * Returns the line on which the token was found.
     */
    public function getLine(): int;
}
