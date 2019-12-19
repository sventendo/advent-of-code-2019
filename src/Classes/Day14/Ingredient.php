<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day14;

class Ingredient
{
    /** @var string */
    public $name;
    /** @var int */
    public $perBatch;
    /** @var CookBook */
    public $cookBook;

    public function __construct(string $name, int $needs, CookBook $cookBook)
    {
        $this->name = $name;
        $this->perBatch = $needs;
        $this->cookBook = $cookBook;
    }

    public function getOreRequirement(int $batches): void
    {
        if ($this->name === 'ORE') {
            $this->print(sprintf('Consuming %d (%d x %d) ORE', $batches * $this->perBatch, $batches, $this->perBatch));
            $this->cookBook->oreRequirement += $batches * $this->perBatch;
            $this->print('Total ore requirement so far: ' . $this->cookBook->oreRequirement);
            $this->print('');
            return;
        }


        $recipe = $this->cookBook->getRecipe($this->name);
        $yields = $recipe->quantity;

        $factor = $this->calculateFactor($recipe, $batches);
        $this->print($this->perBatch * $batches . ' of ' . $recipe->name . ' needed.');
        $this->print($this->cookBook->getStorage($recipe->name) . ' ' . $recipe->name . ' in storage.');
        $this->print('Making ' . $factor . ' batches of ' . $yields . '.');
        $leftover = $yields * $factor - $this->perBatch * $batches;
        if ($leftover > 0) {
            $this->print('Putting ' . $leftover . ' into storage.');
        } else {
            $this->print('Taking ' . abs($leftover) . ' from storage.');
        }

        $this->cookBook->addStorage($recipe->name, $leftover);
        $this->print($recipe->storage . ' in storage.');
        $this->print('');

        $recipe->getTotalOreRequirement($factor);
    }

    public function calculateFactor(Recipe $recipe, int $batches)
    {
        if ($this->perBatch * $batches >= $recipe->storage) {
            $needsOnTop = $this->perBatch * $batches - $recipe->storage;
        } else {
            $needsOnTop = 0;
        }

        $factor = ceil($needsOnTop / $recipe->quantity);

        return (int) $factor;
    }

    private function print(string $message)
    {
        if ($this->cookBook->debug) {
            print $message . PHP_EOL;
        }
    }
}
