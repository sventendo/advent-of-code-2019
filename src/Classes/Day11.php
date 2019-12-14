<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019;

use Sventendo\AdventOfCode2019\Day11\PaintJob;

class Day11 extends Day
{
    public function firstPuzzle($input): string
    {
        $this->parseInput($input);
        $paintJob = new PaintJob();
        $paintJob->start($this->input, 0);

        return (string) $paintJob->countPanelsPointed();
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);
        $paintJob = new PaintJob();
        $paintJob->start($this->input, 1);
        $paintJob->print();

        return (string) '';
    }

    protected function parseInput(string $input): void
    {
        $this->input = $this->inputParser->listToArray($input, false);
    }
}
