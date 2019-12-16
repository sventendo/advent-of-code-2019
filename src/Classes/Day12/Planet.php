<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day12;

use Sventendo\AdventOfCode2019\Vector3d;

class Planet
{
    /** @var Vector3d */
    protected $velocity;
    /** @var Vector3d */
    protected $position;

    public function __construct(Vector3d $position)
    {
        $this->position = $position;
        $this->velocity = new Vector3d(0, 0, 0);
    }

    public function gravitateTowards(Planet $planet)
    {
        $this->velocity->add(
            new Vector3d(
                $planet->getPosition()->getX() <=> $this->getPosition()->getX(),
                $planet->getPosition()->getY() <=> $this->getPosition()->getY(),
                $planet->getPosition()->getZ() <=> $this->getPosition()->getZ()
            )
        );
    }

    public function applyVelocity()
    {
        $this->position->add($this->velocity);
    }

    public function getVelocity(): Vector3d
    {
        return $this->velocity;
    }

    public function getPosition(): Vector3d
    {
        return $this->position;
    }

    public function getEnergy(): int
    {
        return $this->position->sum() * $this->velocity->sum();
    }
}
