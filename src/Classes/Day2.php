<?php
namespace Sventendo\AdventOfCode2019;


use Sventendo\AdventOfCode2019\Day2\IntcodeComputer;

class Day2 extends Day
{
    /** @var IntcodeComputer */
    protected $intcodeComputer;

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);

        $this->intcodeComputer = new IntcodeComputer($this->input);
        $this->intcodeComputer->setValue(1, 12);
        $this->intcodeComputer->setValue(2, 2);

        $this->intcodeComputer->run();

        return (string) $this->intcodeComputer->getValue(0);
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        for ($noun = 0; $noun < 99; $noun++) {
            for ($verb = 0; $verb < 99; $verb++) {
                $this->intcodeComputer = new IntcodeComputer($this->input);
                $this->intcodeComputer->setValue(1, $noun);
                $this->intcodeComputer->setValue(2, $verb);

                $this->intcodeComputer->run();

                $output = $this->intcodeComputer->getValue(0);

                if ($output === 19690720) {
                    return (string) ($noun * 100 + $verb);
                }
            }
        }

        return 'ERROR: No matching pair found.';
    }

    protected function parseInput(string $input): void
    {
        $this->input = $this->inputParser->listToArray($input);
    }
}
