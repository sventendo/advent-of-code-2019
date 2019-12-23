<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019;

use Sventendo\AdventOfCode2019\Day15\ExplorerProgram;
use Sventendo\AdventOfCode2019\Day15\FloodProgression;
use Sventendo\AdventOfCode2019\Day15\PathFinder;

class Day15 extends Day
{
    public function firstPuzzle($input): string
    {
        $this->parseInput($input);

        $explorerProgram = new ExplorerProgram($this->input, true);
        $explorerProgram->run();

        $maze = $explorerProgram->getMaze();
        $pathFinder = new PathFinder($maze, true);

        $origin = new Vector(0, 0);
        $oxygenSystem = $maze->getOxygenSystem();
        $shortestRoute = $pathFinder->getShortestRoute($origin, $oxygenSystem);

        print json_encode($shortestRoute) . PHP_EOL;

        return (string) \count($shortestRoute);
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        $explorerProgram = new ExplorerProgram($this->input);
        $explorerProgram->run();

        $maze = $explorerProgram->getMaze();
        $floodProgression = new FloodProgression($maze, true);
        return (string) $floodProgression->run($maze->getOxygenSystem());

    }

    protected function parseInput(string $input): void
    {
        $this->input = $this->inputParser->listToArray($input, false);
    }
}
