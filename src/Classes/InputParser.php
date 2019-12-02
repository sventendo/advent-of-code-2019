<?php
namespace Sventendo\AdventOfCode2019;

class InputParser
{
    public function linesToArray(string $input)
    {
        return array_filter(
            explode(PHP_EOL, $input),
            function (string $line) {
                return trim($line) !== '';
            }
        );
    }
}
