<?php

namespace Sventendo\AdventOfCode2019;

abstract class Day
{
    /** @var InputParser */
    protected $inputParser;

    protected $input;

    public function __construct(InputParser $inputParser)
    {
        $this->inputParser = $inputParser;
    }

    protected abstract function parseInput(string $input): void;

    public abstract function firstPuzzle($input):string;

    public abstract function secondPuzzle($input):string;
}
