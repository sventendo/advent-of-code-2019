<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019;

use Sventendo\AdventOfCode2019\Day15\ExplorerProgram;
use Sventendo\AdventOfCode2019\Day15\FloodProgression;
use Sventendo\AdventOfCode2019\Day15\PathFinder;
use Sventendo\AdventOfCode2019\Day16\FlawedFrequencyTransmission;

class Day16 extends Day
{
    public function firstPuzzle($input): string
    {
        $this->parseInput($input);

        $flawedFrequencyTransmission = new FlawedFrequencyTransmission($this->input);
        $flawedFrequencyTransmission->run(100);

        return substr($flawedFrequencyTransmission->getLastHash(), 0, 8);
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        $flawedFrequencyTransmission = new FlawedFrequencyTransmission($this->input);
        return $flawedFrequencyTransmission->runForHashInSecondHalf(100, 10000);
    }

    protected function parseInput(string $input): void
    {
        $this->input = $this->inputParser->singleLine($input);
    }
}
