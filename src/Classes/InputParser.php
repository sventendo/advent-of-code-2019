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

    public function listToArray(string $input, bool $parseToInt = true)
    {
        $values = explode(',', $input);
        return array_map(
            function (string $value) use ($parseToInt) {
                if ($parseToInt) {
                    return (int) $value;
                }
                return $value;
            },
            $values
        );
    }

    public function listsToArrays(string $input): array
    {
        return array_map(
            function ($line) {
                return $this->listToArray($line, false);
            },
            explode(PHP_EOL, $input)
        );
    }
}
