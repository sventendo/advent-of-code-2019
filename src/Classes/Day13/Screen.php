<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day13;

class Screen
{
    /** @var array[] */
    protected $tiles = [ [] ];

    /** @var Tile */
    protected $ball;
    /** @var Tile */
    private $paddle;
    /** @var int */
    private $highscore = 0;

    private $tileMap = [
        Tile::TYPE_EMPTY => '.',
        Tile::TYPE_WALL => '|',
        Tile::TYPE_BLOCK => 'X',
        Tile::TYPE_PADDLE => '_',
        Tile::TYPE_BALL => 'o',
    ];

    public function addTile(Tile $tile)
    {
        $this->tiles[$tile->getY()] = $this->tiles[$tile->getY()] ?? [];
        $this->tiles[$tile->getY()][$tile->getX()] = $tile->getType();

        if ($tile->getType() === Tile::TYPE_BALL) {
            $this->ball = $tile;
        }

        if ($tile->getType() === Tile::TYPE_PADDLE) {
            $this->paddle = $tile;
        }
    }

    public function countTiles(int $type): int
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

    public function getBall(): ?Tile
    {
        return $this->ball;
    }

    public function getPaddle(): ?Tile
    {
        return $this->paddle;
    }

    public function getHighscore(): int
    {
        return $this->highscore;
    }

    public function setHighscore(int $highscore): void
    {
        $this->highscore = $highscore;
    }

    public function print(): void
    {
        foreach ($this->tiles as &$row) {
            $row = implode('', $row);
        }

        print implode(PHP_EOL, $canvas) . PHP_EOL . PHP_EOL;
    }
}
