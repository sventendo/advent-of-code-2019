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
                $newitems = $items;
                $newperms = $permutation;
                list($foo) = array_splice($newitems, $i, 1);
                array_unshift($newperms, $foo);
                $this->permute($newitems, $newperms);
            }
        }
    }

    public function getPermutations(): array
    {
        return $this->permutations;
    }
}
