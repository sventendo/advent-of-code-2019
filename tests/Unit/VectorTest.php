<?php
namespace Sventendo\AdventOfCode2019\Tests\Unit;

use Sventendo\AdventOfCode2019\Vector;

class VectorTest extends \PHPUnit\Framework\TestCase
{
    public function testToString()
    {
        $vector = new Vector(1, 2);
        $this->assertEquals('1,2', $vector->__toString());
        $this->assertEquals('[1,2]', json_encode($vector));
    }
}
