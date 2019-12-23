<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day15;

use Sventendo\AdventOfCode2019\Vector;

class Printer
{
    /** @var Maze */
    private $maze;
    /** @var Droid */
    private $droid;
    private $tileMap = [
        'X',
        ' ',
        'F',
        '.',
        'O',
    ];
    private $canvas = [ [] ];
    private $leftBorder;
    private $rightBorder;
    private $upperBorder;
    private $lowerBorder;
    /** @var Vector[] */
    private $path;

    /**
     * @param Maze $maze
     * @param Droid|null $droid
     * @param Vector[] $path
     */
    public function __construct(Maze $maze, Droid $droid = null, array $path = [])
    {
        $this->maze = $maze;
        $this->droid = $droid;
        $this->path = $path;
    }

    public function print(bool $printDroid = true): void
    {
        $this->leftBorder = min(
            array_map(
                function (array $row) {
                    return min(array_keys($row));
                },
                $this->maze->getTiles()
            )
        );
        $this->rightBorder = max(
            array_map(
                function (array $row) {
                    return max(array_keys($row));
                },
                $this->maze->getTiles()
            )
        );
        $this->upperBorder = min(array_keys($this->maze->getTiles()));
        $this->lowerBorder = max(array_keys($this->maze->getTiles()));

        if ($this->lowerBorder - $this->upperBorder < 0 || $this->rightBorder - $this->leftBorder < 0) {
            throw new \Exception('Borders make no sense.');
        }

        for ($y = 0; $y <= $this->lowerBorder - $this->upperBorder; $y++) {
            $this->canvas[$y] = array_fill(0, $this->rightBorder - $this->leftBorder + 1, '.');
        }

        foreach ($this->maze->getTiles() as $y => $row) {
            /** @var int $tile */
            foreach ($row as $x => $tile) {
                if (!array_key_exists($y - $this->upperBorder, $this->canvas)) {
                    throw new \Exception('Value out of bounds: ' . ($y - $this->upperBorder));
                }
                $this->canvas[$y - $this->upperBorder][$x - $this->leftBorder] = $this->tileMap[$tile];
            }
        }

        if ($printDroid) {
            $this->drawTile($this->droid->getPosition(), $this->droid->getIcon());
        }

        foreach ($this->path as $index => $pathTile) {
            if ($index === \count($this->path) - 1) {
                $this->drawTile($pathTile, "\033[01;34m*\033[0m");
            } else {
                $this->drawTile($pathTile, "\033[01;33m*\033[0m");
            }
        }

        $this->drawTile(new Vector(0, 0), '0');

        foreach ($this->canvas as $row) {
            print implode('', $row) . PHP_EOL;
        }
        print PHP_EOL;
    }

    private function drawTile(Vector $position, string $icon)
    {
        $y = $position->getY() - $this->upperBorder;
        $x = $position->getX() - $this->leftBorder;
        $this->canvas[$y][$x] = $icon;
    }

}
