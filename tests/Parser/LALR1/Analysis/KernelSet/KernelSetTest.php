<?php

declare(strict_types=1);

namespace Dissect\Parser\LALR1\Analysis\KernelSet;

use PHPUnit\Framework\TestCase;

class KernelSetTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function kernelsShouldBeProperlyHashedAndOrdered(): void
    {
        $this->assertEquals(array(1, 3, 6, 7), KernelSet::hashKernel(array(
            array(2, 1),
            array(1, 0),
            array(2, 0),
            array(3, 0),
        )));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function insertShouldInsertANewNodeIfNoIdenticalKernelExists(): void
    {
        $set = new KernelSet();

        $this->assertEquals(0, $set->insert([
            [2, 1],
        ]));

        $this->assertEquals(1, $set->insert([
            [2, 2],
        ]));

        $this->assertEquals(2, $set->insert([
            [1, 1],
        ]));

        $this->assertEquals(0, $set->insert([
            [2, 1],
        ]));
    }
}
