<?php
namespace Sventendo\AdventOfCode2019\Tests\Unit\Day7;

use PHPUnit\Framework\TestCase;
use Sventendo\AdventOfCode2019\Day7\Mutator;

class MutatorTest extends TestCase
{
    public function testGetPermutations()
    {
        $subject = new Mutator();

        $subject->permute([ 'foo', 'bar', 'baz' ]);
        $this->assertCount(6, $subject->getPermutations());
    }
}
