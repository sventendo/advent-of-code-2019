<?php
namespace Sventendo\AdventOfCode2019;

use Sventendo\AdventOfCode2019\Day9\IntcodeComputer;

class Day9 extends Day
{
    /** @var IntcodeComputer */
    protected $intcodeComputer;

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);

        $this->intcodeComputer = new IntcodeComputer($this->input, [ 1 ]);

        $response = $this->intcodeComputer->run();

        if (\count($response->getOutput()) > 1) {
            throw new \Exception('Some opcodes are functioning incorrectly: ' . json_encode($response->getOutput()));
        }

        return (string) $response->getValue();
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        $this->intcodeComputer = new IntcodeComputer($this->input, [ 2 ]);

        return (string) $this->intcodeComputer->run()->getValue();
    }

    protected function parseInput(string $input): void
    {
        $this->input = $this->inputParser->listToArray($input, false);
    }
}
