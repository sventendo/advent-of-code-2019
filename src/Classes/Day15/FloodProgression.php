<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day15;

use Sventendo\AdventOfCode2019\Vector;

class FloodProgression
{

    /** @var Maze */
    protected $maze;
    /** @var bool */
    protected $debug;

    public function __construct(Maze $maze, bool $debug = false)
    {
        $this->maze = $maze;
        $this->debug = $debug;
    }

    public function run(Vector $startingLocation): int
    {
        $paths = [ [ $startingLocation ] ];
        $deadEnds = [];
        while ($this->maze->countTilesOfType(Maze::TILE_FLOOR) > 0) {
            $path = array_shift($paths);
            $lastTile = $path[\count($path) - 1];
            $adjacentFloorTiles = $this->maze->getAdjacentFloorTiles($lastTile);

            foreach ($adjacentFloorTiles as $tile) {
                $this->maze->setTile($tile, Maze::TILE_OXYGEN);
                if ($this->alreadyBeenThere($tile, $path)) {
                    $this->print('Dead end found at ' . json_encode($tile));
                    $deadEnds[] = $path;
                    continue;
                }

                $newPath = $path;
                $newPath[] = $tile;

                if (\count($adjacentFloorTiles) > 2) {
                    $this->print('Intersection found at ' . json_encode($tile));
                    if ($this->debug) {
                        $printer = new Printer($this->maze);
                        $printer->print(false);
                    }
                }

                $paths[] = $newPath;
            }
        }

        usort(
            $deadEnds,
            function (array $pathA, array $pathB) {
                return \count($pathB) <=> \count($pathA);
            }
        );

        return \count($deadEnds[0]);
    }

    private function alreadyBeenThere(Vector $tile, array $path)
    {
        if (\count($path) < 2) {
            return false;
        }

        /** @var Vector $secondToLastTile */
        $secondToLastTile = $path[\count($path) - 2];

        return $secondToLastTile->jsonSerialize() === $tile->jsonSerialize();
    }

    private function print(string $message)
    {
        if ($this->debug) {
            print $message . PHP_EOL;
        }
    }
}
