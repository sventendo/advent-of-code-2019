<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Tests\Unit\Day15;

use PHPUnit\Framework\TestCase;
use Sventendo\AdventOfCode2019\Day15\Maze;
use Sventendo\AdventOfCode2019\Day15\PathFinder;
use Sventendo\AdventOfCode2019\Vector;

class PathFinderTest extends TestCase
{
    public function testShortestRoute()
    {
        $tiles = [
            [ '#', ' ', '#', '#', ],
            [ '#', ' ', ' ', ' ', ],
            [ ' ', ' ', '#', ' ', ],
            [ ' ', '#', '#', ' ', ],
            [ ' ', ' ', ' ', ' ', ],
        ];

        $maze = new Maze();
        $maze->setTilesFromMap($tiles);

        $pathFinder = new PathFinder($maze);
        $shortestRoute = $pathFinder->getShortestRoute(new Vector(1, 0), new Vector(3, 4));

        $this->assertEquals('[[1,0],[1,1],[2,1],[3,1],[3,2],[3,3]]', json_encode($shortestRoute));
    }
}
