<?php
namespace Sventendo\AdventOfCode2019;

use Sventendo\AdventOfCode2019\Day5\IntcodeComputer;
use Sventendo\AdventOfCode2019\Day6\OrbitCounter;
use Sventendo\AdventOfCode2019\Day7\AmplifierChain;
use Sventendo\AdventOfCode2019\Day7\AmplifierChainOptimizer;
use Sventendo\AdventOfCode2019\Day7\Mutator;

class Day7 extends Day
{
    /** @var OrbitCounter */
    protected $orbitCounter;

    /** @var AmplifierChainOptimizer */
    protected $amplifierChainOptimizer;

    public function __construct(InputParser $inputParser, AmplifierChainOptimizer $amplifierChainOptimizer)
    {
        parent::__construct($inputParser);
        $this->amplifierChainOptimizer = $amplifierChainOptimizer;
    }

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);

        return (string) $this->amplifierChainOptimizer->getHighestOutput($this->input, range(0, 4), false);
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        return (string) $this->amplifierChainOptimizer->getHighestOutput($this->input, range(5, 9), true);
    }

    protected function parseInput(string $input): void
    {
        $this->input = $this->inputParser->listToArray($input, false);
    }
}
