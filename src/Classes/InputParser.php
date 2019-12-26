<?php
namespace Sventendo\AdventOfCode2019;

class InputParser
{
    public function linesToArray(string $input): array
    {
        return array_filter(
            explode(PHP_EOL, $input),
            function (string $line) {
                return trim($line) !== '';
            }
        );
    }

    public function singleLine(string $input): string
    {
        return explode(PHP_EOL, $input)[0];
    }

    public function lineToArray(string $input, bool $parseToInt = false): array
    {
        $line = explode(PHP_EOL, $input)[0];

        $values = str_split($line);

        if ($parseToInt === true) {
            return array_map('intval', $values);
        }

        return $values;
    }

    public function listToArray(string $input, bool $parseToInt = true): array
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
