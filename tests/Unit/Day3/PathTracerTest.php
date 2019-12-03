<?php
namespace Sventendo\AdventOfCode2019\Tests\Unit\Day3;

use PHPUnit\Framework\TestCase;
use Sventendo\AdventOfCode2019\Day3\PathTracer;

class PathTracerTest extends TestCase
{
    public function testTrace()
    {
        $directionCodes = [ 'U1', 'R1', 'D2', 'L2' ];
        $tracer = new PathTracer($directionCodes);
        $coordinates = [ '[0,0]', '[0,-1]', '[1,-1]', '[1,0]', '[1,1]', '[0,1]', '[-1,1]' ];
        $this->assertEquals($coordinates, $tracer->trace());
    }
}
