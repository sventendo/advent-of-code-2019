<?php
namespace Sventendo\AdventOfCode2019\Day7;

class Mutator
{
    protected $permutations = [];

    function permute($items, $permutation = [])
    {
        if (empty($items)) {
            $this->permutations[] = $permutation;
        } else {
            for ($i = count($items) - 1; $i >= 0; --$i) {
                $newItems = $items;
                $newPermutations = $permutation;
                [ $foo ] = array_splice($newItems, $i, 1);
                array_unshift($newPermutations, $foo);
                $this->permute($newItems, $newPermutations);
            }
        }
    }

    public function getPermutations(): array
    {
        return $this->permutations;
    }
}
