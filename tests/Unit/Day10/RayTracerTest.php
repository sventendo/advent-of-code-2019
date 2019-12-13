<?php
namespace Sventendo\AdventOfCode2019\Tests\Unit\Day10;

use PHPUnit\Framework\TestCase;
use Sventendo\AdventOfCode2019\Day10\RayTracer;
use Sventendo\AdventOfCode2019\Day10\StarMap;

class RayTracerTest extends TestCase
{
    public function test5x5()
    {
        $rows = [
            '.#..#',
            '.....',
            '#####',
            '....#',
            '...##',
        ];

        $starMap = new StarMap($rows);
        $subject = new RayTracer($starMap);

        $subject->trace();

        $this->assertEquals(8, \count($subject->getRaysForStar('4|3')));
        $this->assertEquals(7, \count($subject->getRaysForStar('2|3')));
        $this->assertEquals('4|3', $subject->getStarWithMostRays());
    }

    public function test20x20()
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
        $subject = new RayTracer($starMap);

        $subject->trace();

        $this->assertEquals('13|11', $subject->getStarWithMostRays());
        $this->assertEquals(210, \count($subject->getRaysForStarWithMostRays()));
    }

    public function testStarWithMostRays()
    {
        $rows = [
            '......#.#.',
            '#..#.#....',
            '..#######.',
            '.#.#.###..',
            '.#..#.....',
            '..#....#.#',
            '#..#....#.',
            '.##.#..###',
            '##...#..#.',
            '.#....####',
        ];

        $starMap = new StarMap($rows);
        $subject = new RayTracer($starMap);

        $subject->trace();

        $this->assertEquals('8|5', $subject->getStarWithMostRays());
        $this->assertEquals(33, \count($subject->getRaysForStarWithMostRays()));
    }
}
