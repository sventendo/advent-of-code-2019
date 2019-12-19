<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day14;

class CookBook implements \JsonSerializable
{
    /** @var bool */
    public $debug;
    /** @var int */
    public $oreRequirement = 0;
    /** @var Recipe[] */
    protected $recipes = [];

    public function __construct(array $lines, bool $debug = false)
    {
        $this->debug = $debug;
        foreach ($lines as $line) {
            $recipe = Recipe::fromLine($line, $this);
            $this->recipes[$recipe->name] = $recipe;
        }
    }

    public function reset()
    {
        foreach ($this->recipes as $recipe) {
            $recipe->storage = 0;
        }
        $this->oreRequirement = 0;
    }

    public function getRecipe(string $name): Recipe
    {
        return $this->recipes[$name];
    }

    public function jsonSerialize(): array
    {
        return $this->recipes;
    }

    public function addStorage(string $name, int $amount): void
    {
        $this->recipes[$name]->storage += $amount;
    }

    public function setStorage(string $name, int $amount): void
    {
        $this->recipes[$name]->storage = $amount;
    }

    public function getStorage(string $name): int
    {
        return $this->recipes[$name]->storage;
    }
}
