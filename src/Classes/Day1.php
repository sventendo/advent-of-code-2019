<?php
namespace Sventendo\AdventOfCode2019;


use Sventendo\AdventOfCode2019\Day1\FuelCalculator;

class Day1 extends Day
{
    /** @var FuelCalculator */
    protected $fuelCalculator;

    public function __construct(InputParser $inputParser, FuelCalculator $fuelCalculator)
    {
        parent::__construct($inputParser);
        $this->fuelCalculator = $fuelCalculator;
    }

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);

        $totalFuel = 0;
        array_map(
            function ($mass) use (&$totalFuel) {
                $totalFuel += $this->fuelCalculator->calculate((int) $mass);
            },
            $this->input
        );

        return $totalFuel;
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        $totalFuel = 0;
        array_map(
            function ($mass) use (&$totalFuel) {
                $totalFuel += $this->fuelCalculator->calculateRecursive((int) $mass);
            },
            $this->input
        );

        return $totalFuel;
    }

    protected function parseInput(string $input): void
    {
        $this->input = $this->inputParser->linesToArray($input);
    }
}
