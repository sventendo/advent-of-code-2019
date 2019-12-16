<?php
namespace Sventendo\AdventOfCode2019\Day12;

class Orbit
{
    /** @var Planet[] */
    protected $planets;

    public function __construct(array $planets)
    {
        $this->planets = $planets;
    }

    public function step()
    {
        $this->applyGravityToAllPlanets();
        $this->applyVelocityToAllPlanets();
    }

    public function steps($steps = 1)
    {
        for ($step = 0; $step < $steps; $step++) {
            $this->step();
        }
    }

    public function getEnergy(): int
    {
        $energy = 0;

        foreach ($this->planets as $planet) {
            $energy += $planet->getEnergy();
        }

        return $energy;
    }

    public function takeSnapshot(int $dimension): array
    {
        $values = [];
        foreach ($this->planets as $planet) {
            $values[] = $planet->getPosition()->getDimension($dimension);
            $values[] = $planet->getVelocity()->getDimension($dimension);
        }

        return $values;
    }

    protected function applyGravityToAllPlanets(): void
    {
        foreach ($this->planets as $i => $planetFrom) {
            foreach ($this->planets as $j => $planetTo) {
                if ($i === $j) {
                    continue;
                }
                $planetFrom->gravitateTowards($planetTo);
            }
        }
    }

    protected function applyVelocityToAllPlanets(): void
    {
        foreach ($this->planets as $planet) {
            $planet->applyVelocity();
        }
    }
}
