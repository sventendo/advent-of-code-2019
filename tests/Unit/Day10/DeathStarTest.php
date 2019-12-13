<?php
namespace Sventendo\AdventOfCode2019\Tests\Unit\Day10;

use PHPUnit\Framework\TestCase;
use Sventendo\AdventOfCode2019\Day10\DeathStar;
use Sventendo\AdventOfCode2019\Day10\RayTracer;
use Sventendo\AdventOfCode2019\Day10\StarMap;

class DeathStarTest extends TestCase
{
    public function testSpinLaser()
    {
        $rows = [
            '.#....#####...#..',
            '##...##.#####..##',
            '##...#...#.#####.',
            '..#.....#...###..',
            '..#.#.....#....##',
        ];

        $starMap = new StarMap($rows);
        $rayTracer = new RayTracer($starMap);
        $rayTracer->trace();

        $deathStar = new DeathStar($starMap, $rayTracer->getRaysForStar('3|8'));
        $this->assertEquals('1|15', $deathStar->spinLaser(9)->getPosition());

        $deathStar = new DeathStar($starMap, $rayTracer->getRaysForStar('3|8'));
        $this->assertEquals('4|4', $deathStar->spinLaser(18)->getPosition());
    }

    public function testSpinLaser20x20()
    {
        $rows = [
            '.#..##.###...#######',
            '##.############..##.',
            '.#.######.########.#',
            '.###.#######.####.#.',
            '#####.##.#.##.###.##',
            '..#####..#.#########',
            '####################',
            '#.####....###.#.#.##',
            '##.#################',
            '#####.##.###..####..',
            '..######..##.#######',
            '####.##.####...##..#',
            '.#####..#.######.###',
            '##...#.##########...',
            '#.##########.#######',
            '.####.#.###.###.#.##',
            '....##.##.###..#####',
            '.#.#.###########.###',
            '#.#.#.#####.####.###',
            '###.##.####.##.#..##',
        ];

        $starMap = new StarMap($rows);
        $rayTracer = new RayTracer($starMap);
        $rayTracer->trace();

        $deathStar = new DeathStar($starMap, $rayTracer->getRaysForStar('13|11'));
        $this->assertEquals('2|8', $deathStar->spinLaser(200)->getPosition());
    }
}
