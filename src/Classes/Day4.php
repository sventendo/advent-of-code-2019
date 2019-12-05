<?php
namespace Sventendo\AdventOfCode2019;

use Sventendo\AdventOfCode2019\Day4\BruteForce;

class Day4 extends Day
{
    /** @var BruteForce */
    protected $bruteForce;

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);

        $this->bruteForce = new BruteForce($this->input[0], $this->input[1]);
        $candidates = $this->bruteForce->crack();

        return (string) \count($candidates);
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        $this->bruteForce = new BruteForce($this->input[0], $this->input[1]);
        $candidates = $this->bruteForce->crack(true);

        return (string) \count($candidates);
    }

    protected function parseInput(string $input): void
    {
        if (preg_match('/(\d{6})\-(\d{6})/', $input, $matches)) {
            $this->input = [ (int) $matches[1], (int) $matches[2] ];
        }
    }

    protected function totalSteps(string $crossing, array $coordinatesWireA, array $coordinatesWireB)
    {
        return array_search($crossing, $coordinatesWireA) + array_search($crossing, $coordinatesWireB);
    }
}
