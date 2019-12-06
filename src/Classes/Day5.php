<?php
namespace Sventendo\AdventOfCode2019;

use Sventendo\AdventOfCode2019\Day5\IntcodeComputer;

class Day5 extends Day
{
    /** @var IntcodeComputer */
    protected $intcodeComputer;

    public function __construct(InputParser $inputParser)
    {
        parent::__construct($inputParser);
    }

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);

        $this->intcodeComputer = new IntcodeComputer($this->input);
        return (string) $this->intcodeComputer->run(1);
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        $this->intcodeComputer = new IntcodeComputer($this->input);
        return (string) $this->intcodeComputer->run(5);
    }

    protected function parseInput(string $input): void
    {
        $this->input = $this->inputParser->listToArray($input, false);
    }

    protected function totalSteps(string $crossing, array $coordinatesWireA, array $coordinatesWireB)
    {
        return array_search($crossing, $coordinatesWireA) + array_search($crossing, $coordinatesWireB);
    }
}
