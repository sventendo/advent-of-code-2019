<?php
namespace Sventendo\AdventOfCode2019\Tests\Unit\Day5;

use PHPUnit\Framework\TestCase;
use Sventendo\AdventOfCode2019\Day5\IntcodeComputer;

class IntcodeComputerTest extends TestCase
{
    public function testGetOpcade()
    {
        $subject = new IntcodeComputer();
        $this->assertEquals(2, $subject->getOpcode(1002));
        $this->assertEquals(3, $subject->getOpcode(3));
    }

    /**
     * @dataProvider getTestRunData
     */
    public function testRun(string $valueList, int $input, int $output)
    {
        $values = explode(',', $valueList);
        $subject = new IntcodeComputer($values);
        $this->assertEquals($output, $subject->run($input));
    }

    public function getTestRunData()
    {
        return [
//            [ '3,12,6,12,15,1,13,14,13,4,13,99,-1,0,1,9', 0, 0 ],
//            [ '3,12,6,12,15,1,13,14,13,4,13,99,-1,0,1,9', 1, 1 ],
//            [ '3,3,1105,-1,9,1101,0,0,12,4,12,99,1', 0, 0 ],
//            [ '3,3,1105,-1,9,1101,0,0,12,4,12,99,1', 1, 1 ],
            [
                '3,21,1008,21,8,20,1005,20,22,107,8,21,20,1006,20,31,1106,0,36,98,0,0,1002,21,125,20,4,20,1105,1,46,104,999,1105,1,46,1101,1000,1,20,4,20,1105,1,46,98,99',
                7,
                999,
            ],
//            [
//                '3,21,1008,21,8,20,1005,20,22,107,8,21,20,1006,20,31,1106,0,36,98,0,0,1002,21,125,20,4,20,1105,1,46,104,999,1105,1,46,1101,1000,1,20,4,20,1105,1,46,98,99',
//                8,
//                1000,
//            ],
//            [
//                '3,21,1008,21,8,20,1005,20,22,107,8,21,20,1006,20,31,1106,0,36,98,0,0,1002,21,125,20,4,20,1105,1,46,104,999,1105,1,46,1101,1000,1,20,4,20,1105,1,46,98,99',
//                9,
//                1001,
//            ],
        ];
    }
}
