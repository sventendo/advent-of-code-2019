<?php
namespace Sventendo\AdventOfCode2019\Tests\Unit;

use Sventendo\AdventOfCode2019\Day11;

class Day11Test extends TestCase
{
    public function setUp()
    {
        $this->subject = $this->container->make(Day11::class);
        $this->input = file_get_contents(__DIR__ . '/../../resources/day11.txt');
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
