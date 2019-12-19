<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day14;

class Recipe implements \JsonSerializable
{
    /** @var string */
    public $name;
    /** @var int */
    public $quantity;
    /** @var Ingredient[] */
    public $ingredients;
    /** @var int */
    public $storage = 0;
    /** @var CookBook */
    public $cookBook;

    public function __construct(string $name, int $quantity, array $ingredients, CookBook $cookBook)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->ingredients = $ingredients;
        $this->cookBook = $cookBook;
    }

    public static function fromLine(string $line, CookBook $cookBook)
    {
        [ $ingredientsList, $result ] = explode(' => ', $line);
        [ $quantity, $name ] = explode(' ', $result);
        $ingredientsWithQuantity = explode(', ', $ingredientsList);
        $ingredients = [];
        foreach ($ingredientsWithQuantity as $ingredient) {
            [ $needsHowMuch, $needsWhat ] = explode(' ', $ingredient);
            $ingredients[] = new Ingredient($needsWhat, (int) $needsHowMuch, $cookBook);
        }

        return new Recipe($name, (int) $quantity, $ingredients, $cookBook);
    }

    public function getTotalOreRequirement(int $amount)
    {
        /** @var Ingredient $ingredient */
        foreach ($this->ingredients as $ingredient) {
            $ingredient->getOreRequirement($amount);
        }
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'quantity' => $this->quantity,
            'storage' => $this->storage,
        ];
    }
}
