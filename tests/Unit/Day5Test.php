<?php
namespace Sventendo\AdventOfCode2019\Tests\Unit;

use Sventendo\AdventOfCode2019\Day5;

class Day5Test extends TestCase
{
    public function setUp()
    {
        $this->subject = $this->container->make(Day5::class);
        $this->input = file_get_contents(__DIR__ . '/../../resources/day5.txt');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testFirstPuzzle()
    {
        $this->print($this->subject->firstPuzzle($this->input));
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testSecondPuzzle()
    {
        $this->print($this->subject->secondPuzzle($this->input));
    }
}
