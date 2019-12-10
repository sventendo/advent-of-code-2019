<?php
namespace Sventendo\AdventOfCode2019\Tests\Unit\Day9;

use PHPUnit\Framework\TestCase;
use Sventendo\AdventOfCode2019\Day9\IntcodeComputer;

class IntcodeComputerTest extends TestCase
{
    public function testRun()
    {
        $subject = new IntcodeComputer(explode(',', '1102,34915192,34915192,7,4,7,99,0'));
        $this->assertEquals(16, strlen($subject->run()->getValue()));

        $subject = new IntcodeComputer(explode(',', '104,1125899906842624,99'));
        $this->assertEquals('1125899906842624', $subject->run()->getValue());
    }

    public function testRelative()
    {
        $subject = new IntcodeComputer(explode(',', '109,1,203,11,209,8,204,1,99,10,0,42,0'), [ 5 ]);
        $this->assertEquals('5', $subject->run()->getValue());
    }

    public function testQuine()
    {
        $software = '109,1,204,-1,1001,100,1,100,1008,100,16,101,1006,101,0,99';
        $subject = new IntcodeComputer(explode(',', $software), []);

        $this->assertEquals(explode(',', $software), $subject->run()->getOutput());
    }

    /** @dataProvider getSingleCommandExamples */
    public function testSingleCommands(string $software, int $input, string $output)
    {
        $subject = new IntcodeComputer(explode(',', $software), [ $input ]);
        $this->assertEquals($output, trim($subject->run()->getValue()));
    }

    public function getSingleCommandExamples()
    {
        return [
            [ '109,-1,4,1,99', 5, -1, ],
            [ '109,-1,104,1,99', 5, 1, ],
            [ '109,-1,204,1,99', 5, 109, ],
            [ '109,1,9,2,204,-6,99', 5, 204, ],
            [ '109,1,109,9,204,-6,99', 5, 204, ],
            [ '109,1,209,-1,204,-106,99', 5, 204, ],
            [ '109,1,3,3,204,2,99', 5, 5, ],
            [ '109,1,203,2,204,2,99', 5, 5, ],
        ];
    }
}
