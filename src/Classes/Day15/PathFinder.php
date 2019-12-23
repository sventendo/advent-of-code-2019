<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day15;

use Sventendo\AdventOfCode2019\Vector;

class PathFinder
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

    public function measureShortestRoute(Vector $from, Vector $to)
    {
        return \count($this->getShortestRoute($from, $to));
    }

    public function getShortestRoute(Vector $from, Vector $to)
    {
        $this->print(sprintf('Finding shortest route from %s to %s...', json_encode($from), json_encode($to)));

        $paths = [ [ $from ] ];

        $successfulPaths = [];

        while (true) {
            $path = array_shift($paths);
            $lastTile = $path[\count($path) - 1];
            $adjacentFloorTiles = $this->maze->getAdjacentFloorTiles($lastTile);

            foreach ($adjacentFloorTiles as $tile) {
                if ($this->alreadyBeenThere($tile, $path)) {
                    $this->print('Dead end found at ' . json_encode($tile));
                    continue;
                }

                $newPath = $path;
                $newPath[] = $tile;

                if (\count($adjacentFloorTiles) > 2) {
                    $this->print('Intersection found at ' . json_encode($tile));
                    if ($this->debug) {
                        $printer = new Printer($this->maze, null, $path);
                        $printer->print(false);
                    }
                }

                if ($tile->jsonSerialize() === $to->jsonSerialize()) {
                    $this->print('Successful path found!');
                    $successfulPaths[] = $path;
                } else {
                    $paths[] = $newPath;
                }
            }

            if (\count($paths) === 0) {
                break;
            }
        }

        usort(
            $successfulPaths,
            function (array $pathA, array $pathB) {
                return \count($pathA) <=> \count($pathB);
            }
        );

        $shortestPath = $successfulPaths[0];

        if ($this->debug) {
            $printer = new Printer($this->maze, null, $shortestPath);
            $printer->print(false);
        }

        return $shortestPath;
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
