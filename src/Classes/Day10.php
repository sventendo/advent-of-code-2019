<?php
namespace Sventendo\AdventOfCode2019;

use Sventendo\AdventOfCode2019\Day10\DeathStar;
use Sventendo\AdventOfCode2019\Day10\RayTracer;
use Sventendo\AdventOfCode2019\Day10\StarMap;
use Sventendo\AdventOfCode2019\Day9\IntcodeComputer;

class Day10 extends Day
{
    /** @var IntcodeComputer */
    protected $intcodeComputer;

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);

        $starMap = new StarMap($this->input);
        $rayTracer = new RayTracer($starMap);

        $rayTracer->trace();

        return (string) \count($rayTracer->getRaysForStarWithMostRays());
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        $starMap = new StarMap($this->input);
        $rayTracer = new RayTracer($starMap);

        $rayTracer->trace();

        $deathStar = new DeathStar($starMap, $rayTracer->getRaysForStarWithMostRays());

        $position = $deathStar->spinLaser(200)->getPosition();

        [ $y, $x ] = explode('|', $position);

        return (string) $x * 100 + $y;
    }

    protected function parseInput(string $input): void
    {
        $this->input = $this->inputParser->linesToArray($input);
    }
}
