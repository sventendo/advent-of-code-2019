<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day10;

class Ray
{
    protected $distance;
    protected $angle;
    protected $position;

    public function __construct(float $distance, float $angle, string $position)
    {
        $this->distance = $distance;
        $this->angle = $angle;
        $this->position = $position;
    }

    public function getDistance(): float
    {
        return $this->distance;
    }

    public function getAngle(): float
    {
        return $this->angle;
    }

    public function getPosition(): string
    {
        return $this->position;
    }
}
