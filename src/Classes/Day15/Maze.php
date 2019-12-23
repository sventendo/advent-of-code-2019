<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day15;

use Sventendo\AdventOfCode2019\Vector;

class Maze
{
    public const TILE_WALL = 0;
    public const TILE_FLOOR = 1;
    public const TILE_OXYGEN_SYSTEM = 2;
    public const TILE_UNKNOWN = 3;
    public const TILE_OXYGEN = 4;


    /** @var array[] */
    protected $tiles;

    /** @var Vector[] */
    protected $walls = [];

    /** @var Vector */
    protected $oxygenSystem;
    private $debug = false;

    public function __construct(bool $debug = false)
    {
        $this->tiles = [ [ self::TILE_FLOOR ] ];
        $this->debug = $debug;
    }

    public function getTiles(): array
    {
        return $this->tiles;
    }

    public function setTiles(array $tiles): void
    {
        $this->tiles = $tiles;
    }

    /**
     * @return Vector[]
     */
    public function getWalls(): array
    {
        return $this->walls;
    }

    public function getOxygenSystem(): ?Vector
    {
        return $this->oxygenSystem;
    }

    public function setOxygenSystem(Vector $oxygenSystem): void
    {
        $this->oxygenSystem = $oxygenSystem;
        $this->setTile($oxygenSystem, self::TILE_OXYGEN_SYSTEM);
    }

    public function setWall(Vector $wall)
    {
        if (($this->walls[$wall->getStringValue()] ?? null) === null) {
            $this->walls[$wall->getStringValue()] = $wall;
        }

        $this->setTile($wall, self::TILE_WALL);
    }

    public function undiscovered(Vector $vector)
    {
        return ($this->tiles[$vector->getY()][$vector->getX()] ?? null) === null;
    }

    public function setFloor(Vector $tile)
    {
        $this->setTile($tile, self::TILE_FLOOR);
    }

    public function getMostInterestingDirection(Droid $droid)
    {
        $directions = [
            Vector::DIRECTION_UP => 50,
            Vector::DIRECTION_RIGHT => 50,
            Vector::DIRECTION_DOWN => 50,
            Vector::DIRECTION_LEFT => 50,
        ];

        foreach ($directions as $direction => $interest) {
            $testPosition = clone($droid->getPosition());
            $testPosition->move($direction);

            $this->print(sprintf('Position %s looks... ', $testPosition->getStringValue()));
            // Undiscovered is always interesting. Go there.
            if ($this->undiscovered($testPosition)) {
                $this->print('... undiscovered! Let\'s go there!');
                return $direction;
            }

            if ($this->getTile($testPosition) === self::TILE_WALL) {
                $this->print('... like a wall.');
                $directions[$direction] = 0;
            } else {
                $stepsAgo = $droid->wasHereStepsAgo($testPosition);
                $this->print(sprintf('... interesting like %d points.', $stepsAgo));
                $directions[$direction] = $stepsAgo;
            }

        }

        asort($directions);

        return array_keys($directions)[3];
    }

    /**
     * @param Vector $lastTile
     * @return Vector[]
     */
    public function getAdjacentFloorTiles(Vector $lastTile): array
    {
        $adjacentFloorTiles = [];

        $directions = [
            Vector::DIRECTION_UP,
            Vector::DIRECTION_RIGHT,
            Vector::DIRECTION_DOWN,
            Vector::DIRECTION_LEFT,
        ];

        foreach ($directions as $direction) {
            $testPosition = clone($lastTile);
            $testPosition->move($direction);

            if (
                $this->getTile($testPosition) === self::TILE_FLOOR
                || $this->getTile($testPosition) === self::TILE_OXYGEN_SYSTEM
                || $this->getTile($testPosition) === self::TILE_OXYGEN
            ) {
                $adjacentFloorTiles[] = $testPosition;
            }
        }

        return $adjacentFloorTiles;
    }

    public function setTilesFromMap(array $tiles)
    {
        $valueMap = [
            '#' => self::TILE_WALL,
            ' ' => self::TILE_FLOOR,
        ];

        foreach ($tiles as $y => $row) {
            $tiles[$y] = array_map(
                function ($tileValue) use ($valueMap) {
                    return $valueMap[$tileValue];
                },
                $row
            );
        }

        $this->setTiles($tiles);
    }

    public function setTile(Vector $tile, int $type): void
    {
        $this->tiles[$tile->getY()] = $this->tiles[$tile->getY()] ?? [];
        $this->tiles[$tile->getY()][$tile->getX()] = $type;
    }

    public function countTilesOfType(int $type)
    {
        $count = 0;
        foreach ($this->tiles as $row) {
            $count += \count(
                array_filter(
                    $row,
                    function (int $value) use ($type) {
                        return $value === $type;
                    }
                )
            );
        }

        return $count;
    }

    protected function print($message)
    {
        if ($this->debug) {
            print $message . PHP_EOL;
        }
    }

    private function getTile(Vector $testPosition): int
    {
        return $this->tiles[$testPosition->getY()][$testPosition->getX()] ?? self::TILE_UNKNOWN;
    }
}
