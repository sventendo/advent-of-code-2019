<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019;

use Sventendo\AdventOfCode2019\Day12\Orbit;
use Sventendo\AdventOfCode2019\Day12\Planet;

class Day12 extends Day
{
    public function firstPuzzle($input): string
    {
        $this->parseInput($input);

        $planetA = new Planet($this->input[0]);
        $planetB = new Planet($this->input[1]);
        $planetC = new Planet($this->input[2]);
        $planetD = new Planet($this->input[3]);

        $orbit = new Orbit([ $planetA, $planetB, $planetC, $planetD ]);

        $orbit->step(1000);

        return (string) $orbit->getEnergy();
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        $cyclesForDimensions = [ 0, 0, 0 ];

        // If this runs forever, run separately for each dimension.
        foreach (range(0, 2) as $dimension) {
            $planetA = new Planet($this->input[0]);
            $planetB = new Planet($this->input[1]);
            $planetC = new Planet($this->input[2]);
            $planetD = new Planet($this->input[3]);

            $orbit = new Orbit([ $planetA, $planetB, $planetC, $planetD ]);

            $initialSnapShot = $orbit->takeSnapshot($dimension);

            $orbit->step();
            $cyclesForDimensions[$dimension]++;

            while ($orbit->takeSnapshot($dimension) !== $initialSnapShot) {
                $orbit->step();
                $cyclesForDimensions[$dimension]++;
            }
        }

        return (string) Math::lcm($cyclesForDimensions[0], Math::lcm($cyclesForDimensions[1], $cyclesForDimensions[2]));
    }

    protected function parseInput(string $input): void
    {
        $lines = $this->inputParser->linesToArray($input);
        $this->input = [];
        foreach ($lines as $line) {
            if (preg_match('/\<x=(\-?\d+),\sy=(\-?\d+),\sz=(\-?\d+)\>/', $line, $matches)) {
                $this->input[] = new Vector3d((int) $matches[1], (int) $matches[2], (int) $matches[3]);
            }
        }
    }
}
