<?php
namespace Sventendo\AdventOfCode2019\Day7;

class AmplifierChainOptimizer
{
    /** @var Mutator */
    private $mutator;

    public function __construct(Mutator $mutator)
    {
        $this->mutator = $mutator;
    }

    public function getHighestOutput(array $software, array $phaseSettings, bool $feedbackLoop)
    {
        $this->mutator->permute($phaseSettings);
        $permutations = $this->mutator->getPermutations();

        $highestValue = 0;


        foreach ($permutations as $permutation) {
            $amplifierChain = new AmplifierChain($software);
            if ($feedbackLoop) {
                $output = $amplifierChain->runFeedbackLoop($permutation);
            } else {
                $output = $amplifierChain->run($permutation);
            }
            $highestValue = max((int) $highestValue, (int) $output);
        }

        return $highestValue;
    }
}
