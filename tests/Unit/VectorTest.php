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

    /**
     * @dataProvider getAngleExamples
     */
    public function testAngle($x1, $y1, $x2, $y2, $angle)
    {
        $vectorA = new Vector($x1, $y1);
        $vectorB = new Vector($x2, $y2);

        $this->assertEquals($angle, (int) $vectorA->angleTo($vectorB));
    }

    public function getAngleExamples()
    {
        return [
            [2, 2, 2, 1, 0],
            [2, 2, 3, 1, 45],
            [2, 2, 4, 1, 63],
            [2, 2, 3, 2, 90],
            [2, 2, 3, 3, 135],
            [2, 2, 2, 3, 180],
            [2, 2, 1, 3, 225],
            [2, 2, 1, 2, 270],
            [2, 2, 1, 1, 315],

            [1, 2, 1, 0, 0],
        ];
    }
}
