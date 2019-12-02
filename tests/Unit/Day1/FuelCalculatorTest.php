<?php
namespace Sventendo\AdventOfCode2019\Tests\Unit\Day1;

use PHPUnit\Framework\TestCase;
use Sventendo\AdventOfCode2019\Day1\FuelCalculator;

class FuelCalculatorTest extends TestCase
{
    /** @var FuelCalculator */
    protected $subject;

    public function setUp()
    {
        $this->subject = new FuelCalculator();
    }

    function testCalculate()
    {
        $this->assertEquals(2, $this->subject->calculate(12));
        $this->assertEquals(2, $this->subject->calculate(14));
        $this->assertEquals(654, $this->subject->calculate(1969));
        $this->assertEquals(33583, $this->subject->calculate(100756));
    }

    function testCalculateRecursive()
    {
        $this->assertEquals(2, $this->subject->calculateRecursive(12));
        $this->assertEquals(966, $this->subject->calculateRecursive(1969));
        $this->assertEquals(50346, $this->subject->calculateRecursive(100756));
    }
}
