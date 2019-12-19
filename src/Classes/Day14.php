<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019;

use Sventendo\AdventOfCode2019\Day14\CookBook;

class Day14 extends Day
{
    public function firstPuzzle($input): string
    {
        $this->parseInput($input);

        $cookBook = new CookBook($this->input);

        $recipeForFuel = $cookBook->getRecipe('FUEL');

        $recipeForFuel->getTotalOreRequirement(1);

        return (string) $cookBook->oreRequirement;
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        $cookBook = new CookBook($this->input);

        $fuel = 1;

        $testFuel = function (CookBook $cookBook, int $fuel) {
            $cookBook->reset();
            $recipeForFuel = $cookBook->getRecipe('FUEL');
            $recipeForFuel->getTotalOreRequirement($fuel);
            print 'Ore requirement: ' . $cookBook->oreRequirement . PHP_EOL;
            print 'Fuel produced: ' . $fuel . PHP_EOL;
            print PHP_EOL;
        };

        // Start off by doubling the fuel requirement until the storage bursts.
        while ($cookBook->oreRequirement < 1000000000000) {
            $fuel *= 2;
            $testFuel($cookBook, $fuel);
        }

        // Go back and forth on the fuel requirements with smaller and smaller increments,
        // until it almost fits. 6 runs feels like a good number.
        $runs = 6;
        for ($run = 0; $run < $runs; $run++) {
            $directionForward = $run % 2 === 1;

            $factor = $directionForward
                ? 1 + (1 / pow(10, $run + 1))
                : 1 - (1 / pow(10, $run + 1));
            $condition = function ($directionForward) use ($cookBook) {
                return $directionForward
                    ? $cookBook->oreRequirement < 1000000000000
                    : $cookBook->oreRequirement > 1000000000000;
            };

            while ($condition($directionForward)) {
                $fuel = (int) round($fuel * $factor);
                $testFuel($cookBook, $fuel);
            }
        }

        // At last go by single decrements until it fits just so.
        while ($cookBook->oreRequirement > 1000000000000) {
            $fuel -= 1;
            $testFuel($cookBook, $fuel);
        }

        print $cookBook->oreRequirement . PHP_EOL;

        return (string) $fuel;
    }

    protected function parseInput(string $input): void
    {
        $this->input = $this->inputParser->linesToArray($input);
    }
}
