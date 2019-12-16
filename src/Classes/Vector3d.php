<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019;

class Vector3d
{
    /** @var int */
    protected $x;
    /** @var int */
    protected $y;
    /** @var int */
    protected $z;

    public function __construct(int $x, int $y, int $z)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getZ(): int
    {
        return $this->z;
    }

    public function add(Vector3d $vector): void
    {
        $this->x += $vector->getX();
        $this->y += $vector->getY();
        $this->z += $vector->getZ();
    }

    public function equals(Vector3d $vector): bool
    {
        return $this->x === $vector->getX()
            && $this->y === $vector->getY()
            && $this->z === $vector->getZ();
    }

    public function toArray(): array
    {
        return [
            $this->x,
            $this->y,
            $this->z,
        ];
    }

    public function sum()
    {
        return abs($this->x) + abs($this->y) + abs($this->z);
    }

    public function __toString()
    {
        return json_encode([ $this->x, $this->y, $this->z ]);
    }

    public function getDimension(int $dimension)
    {
        $dimensions = ['x', 'y', 'z'];

        return $this->{$dimensions[$dimension]};
    }
}
