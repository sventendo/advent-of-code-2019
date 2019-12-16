<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day13;

class Tile
{
    public const TYPE_EMPTY = 0;
    public const TYPE_WALL = 1;
    public const TYPE_BLOCK = 2;
    public const TYPE_PADDLE = 3;
    public const TYPE_BALL = 4;

    /** @var int */
    protected $x;
    /** @var int */
    protected $y;
    /** @var int */
    protected $type;

    public function __construct(int $x, int $y, int $type)
    {
        $this->x = $x;
        $this->y = $y;
        $this->type = $type;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getType(): int
    {
        return $this->type;
    }
}
