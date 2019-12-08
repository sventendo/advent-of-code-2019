<?php
namespace Sventendo\AdventOfCode2019\Tests\Unit;

use Sventendo\AdventOfCode2019\Day8;

class Day6Test extends TestCase
{
    public function setUp()
    {
        $this->subject = $this->container->make(Day8::class);
        $this->input = file_get_contents(__DIR__ . '/../../resources/day8.txt');
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
