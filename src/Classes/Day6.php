<?php
namespace Sventendo\AdventOfCode2019;

use Sventendo\AdventOfCode2019\Day5\IntcodeComputer;
use Sventendo\AdventOfCode2019\Day6\OrbitCounter;

class Day6 extends Day
{
    /** @var OrbitCounter */
    protected $orbitCounter;

    public function __construct(InputParser $inputParser)
    {
        parent::__construct($inputParser);
    }

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);

        $this->orbitCounter = new OrbitCounter($this->input);
        return (string) $this->orbitCounter->countTotalOrbits();
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        $this->orbitCounter = new OrbitCounter($this->input);

        $you = $this->orbitCounter->getPlanet('YOU');
        $santa = $this->orbitCounter->getPlanet('SAN');

        return (string) $this->orbitCounter->calculateTransfersBetween($you, $santa);
    }

    protected function parseInput(string $input): void
    {
        $this->input = $this->inputParser->linesToArray($input);
    }
}
