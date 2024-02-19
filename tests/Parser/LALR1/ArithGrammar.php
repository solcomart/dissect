<?php

declare(strict_types=1);

namespace Dissect\Parser\LALR1;

use Dissect\Parser\Grammar;

class ArithGrammar extends Grammar
{
    /** @noinspection PhpUnusedParameterInspection */
    public function __construct()
    {
        $this('Expr')
            ->is('Expr', '+', 'Expr')
            ->call(fn($l, $_, $r) => $l + $r)

            ->is('Expr', '-', 'Expr')
            ->call(fn($l, $_, $r) => $l - $r)

            ->is('Expr', '*', 'Expr')
            ->call(fn($l, $_, $r) => $l * $r)

            ->is('Expr', '/', 'Expr')
            ->call(fn($l, $_, $r) => $l / $r)

            ->is('Expr', '**', 'Expr')
            ->call(fn($l, $_, $r) => pow($l, $r))

            ->is('(', 'Expr', ')')
            ->call(fn($r, $e, $_) => $e)

            ->is('-', 'Expr')->prec(4)
            ->call(fn($_, $e) => -$e)

            ->is('INT')
            ->call(fn($i) => (int)$i->getValue());

        $this->operators('+', '-')->left()->prec(1);
        $this->operators('*', '/')->left()->prec(2);
        $this->operators('**')->right()->prec(3);

        $this->start('Expr');
    }
}
