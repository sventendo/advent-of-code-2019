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

    public function listToArray(string $input)
    {
        $values = explode(',', $input);
        return array_map(
            function (string $number) {
                return (int) $number;
            },
            $values
        );
    }
}
