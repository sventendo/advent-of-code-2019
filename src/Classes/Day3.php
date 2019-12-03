<?php
namespace Sventendo\AdventOfCode2019;


use Sventendo\AdventOfCode2019\Day3\CrossingsFinder;
use Sventendo\AdventOfCode2019\Day3\DistanceMeasuringService;
use Sventendo\AdventOfCode2019\Day3\PathTracer;

class Day3 extends Day
{
    /** @var CrossingsFinder */
    protected $crossingFinder;

    /** @var DistanceMeasuringService */
    protected $distanceMeasuringService;

    public function __construct(
        InputParser $inputParser,
        CrossingsFinder $crossingFinder,
        DistanceMeasuringService $distanceMeasuringService
    ) {
        parent::__construct($inputParser);
        $this->crossingFinder = $crossingFinder;
        $this->distanceMeasuringService = $distanceMeasuringService;
    }

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);

        $coordinatesWireA = (new PathTracer($this->input[0]))->trace();
        $coordinatesWireB = (new PathTracer($this->input[1]))->trace();

        $crossings = $this->crossingFinder->find($coordinatesWireA, $coordinatesWireB);

        $shortestDistance = $this->distanceMeasuringService->findShortestDistance($crossings);

        return (string) $shortestDistance;
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        $coordinatesWireA = (new PathTracer($this->input[0]))->trace();
        $coordinatesWireB = (new PathTracer($this->input[1]))->trace();

        $crossings = $this->crossingFinder->find($coordinatesWireA, $coordinatesWireB);

        $firstCrossing = array_shift($crossings);
        $fewestSteps = $this->totalSteps($firstCrossing, $coordinatesWireA, $coordinatesWireB);

        foreach ($crossings as $crossing) {
            $fewestSteps = min($fewestSteps, $this->totalSteps($crossing, $coordinatesWireA, $coordinatesWireB));
        }

        return (string) $fewestSteps;
    }

    protected function parseInput(string $input): void
    {
        $this->input = $this->inputParser->listsToArrays($input);
    }

    protected function totalSteps(string $crossing, array $coordinatesWireA, array $coordinatesWireB)
    {
        return array_search($crossing, $coordinatesWireA) + array_search($crossing, $coordinatesWireB);
    }
}
