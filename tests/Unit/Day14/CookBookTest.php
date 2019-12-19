<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Tests\Unit\Day14;

use PHPUnit\Framework\TestCase;
use Sventendo\AdventOfCode2019\Day14\CookBook;

class CookBookTest extends TestCase
{
    /**
     * @dataProvider getTotalOreExamples
     */
    public function testTotalOre(array $lines, int $ore)
    {
        $cookBook = new CookBook($lines);
        $recipeForFuel = $cookBook->getRecipe('FUEL');
        $recipeForFuel->getTotalOreRequirement(1);

        $this->assertEquals($ore, $cookBook->oreRequirement);
    }

    public function testStorage()
    {
        $lines = [
            '10 ORE => 10 A',
        ];

        $cookBook = new CookBook($lines);
        $recipe = $cookBook->getRecipe('A');
        $recipe->storage += 5;

        $this->assertEquals(5, $recipe->storage);
        $recipe = $cookBook->getRecipe('A');
        $this->assertEquals(5, $recipe->storage);
    }

    public function getTotalOreExamples()
    {
        return [
            [
                [
                    '10 ORE => 10 A',
                    '1 ORE => 1 B',
                    '7 A, 1 B => 1 C',
                    '7 A, 1 C => 1 D',
                    '7 A, 1 D => 1 E',
                    '7 A, 1 E => 1 FUEL',
                ],
                31,
            ],
            [
                [
                    '9 ORE => 2 A',
                    '8 ORE => 3 B',
                    '7 ORE => 5 C',
                    '3 A, 4 B => 1 AB',
                    '5 B, 7 C => 1 BC',
                    '4 C, 1 A => 1 CA',
                    '2 AB, 3 BC, 4 CA => 1 FUEL',
                ],
                165,
            ],
        ];
    }

    public function testReset()
    {
        $cookBook = new CookBook(
            [
                '9 ORE => 2 A',
                '8 ORE => 3 B',
                '7 ORE => 5 C',
                '3 A, 4 B => 1 AB',
                '5 B, 7 C => 1 BC',
                '4 C, 1 A => 1 CA',
                '2 AB, 3 BC, 4 CA => 1 FUEL',
            ]
        );

        $recipeForFuel = $cookBook->getRecipe('FUEL');
        $recipeForFuel->getTotalOreRequirement(1);
        $this->assertEquals(165, $cookBook->oreRequirement);

        $cookBook->reset();
        $recipeForFuel->getTotalOreRequirement(1);
        $this->assertEquals(165, $cookBook->oreRequirement);
    }
}
