<?php
namespace Sventendo\AdventOfCode2019\Tests\Unit\Day2;

use PHPUnit\Framework\TestCase;
use Sventendo\AdventOfCode2019\Day2\IntcodeComputer;

class IntcodeComputerTest extends TestCase
{
    public function testGetterAndSetter()
    {
        $computer = new IntcodeComputer([ 1, 9, 10, 3, 2, 3, 11, 0, 99, 30, 40, 50 ]);

        $this->assertEquals(30, $computer->getValue(9));
        $computer->setValue(9, 20);
        $this->assertEquals(20, $computer->getValue(9));
    }

    public function testRun()
    {
        $computer = new IntcodeComputer([ 1, 1, 1, 4, 99, 5, 6, 0, 99 ]);
        $computer->run();

        $this->assertEquals([30,1,1,4,2,5,6,0,99], $computer->getValueList());
    }
}
