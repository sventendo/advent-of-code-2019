<?php
namespace Sventendo\AdventOfCode2019\Day3;

class DistanceMeasuringService
{
    public function findShortestDistance(array $serializedVectors): int
    {
        $firstVector = array_shift($serializedVectors);
        $shortestDistance = $this->manhattanDistance($firstVector);

        foreach ($serializedVectors as $serializedVector) {
            $distance = $this->manhattanDistance($serializedVector);
            $shortestDistance = min($shortestDistance, $distance);
        }

        return $shortestDistance;
    }

    public function manhattanDistance(string $serializedVector): int
    {
        $jsonDecode = json_decode($serializedVector);
        return array_sum(
            array_map(
                function (int $value) {
                    return abs($value);
                },
                $jsonDecode
            )
        );
    }
}
