<?php
namespace Sventendo\AdventOfCode2019\Day3;

class CrossingsFinder
{
    public function find(array $vectorsA, array $vectorsB): array
    {
        array_shift($vectorsA);
        array_shift($vectorsB);

        return array_intersect($vectorsA, $vectorsB);
    }
}
