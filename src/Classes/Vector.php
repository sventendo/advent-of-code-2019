<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019;

class Vector implements \JsonSerializable
{
    /** @var int */
    protected $x;
    /** @var int */
    protected $y;

    public function __construct(int $x = 0, int $y = 0)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function addVector(Vector $vector)
    {
        $this->x += $vector->getX();
        $this->y += $vector->getY();
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function up($steps = 1)
    {
        $this->y -= $steps;
    }

    public function right($steps = 1)
    {
        $this->x += $steps;
    }

    public function down($steps = 1)
    {
        $this->y += $steps;
    }

    public function left($steps = 1)
    {
        $this->x -= $steps;
    }

    public function __toString()
    {
        return $this->x . ',' . $this->y;
    }

    public function jsonSerialize()
    {
        return [ $this->x, $this->y ];
    }
}
