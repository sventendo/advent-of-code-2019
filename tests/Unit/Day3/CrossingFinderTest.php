<?php
namespace Sventendo\AdventOfCode2019\Tests\Unit\Day3;

use PHPUnit\Framework\TestCase;
use Sventendo\AdventOfCode2019\Day3\CrossingsFinder;
use Sventendo\AdventOfCode2019\Day3\PathTracer;

class CrossingFinderTest extends TestCase
{
    public function testFindCrossings()
    {
        $finder = new CrossingsFinder();

        $coordinatesA = (new PathTracer(explode(',', 'R8,U5,L5,D3')))->trace();
        $coordinatesB = (new PathTracer(explode(',', 'U7,R6,D4,L4')))->trace();

        $crossings = $finder->find($coordinatesA, $coordinatesB);

        sort($crossings);

        $this->assertEquals([ '[3,-3]', '[6,-5]' ], $crossings);
    }
}
