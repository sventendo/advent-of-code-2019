<?php
namespace Sventendo\AdventOfCode2019\Day6;

class OrbitCounter
{
    private const ORBIT_CENTER = 'COM';

    protected $planets = [];

    public function __construct(array $orbitData)
    {
        $this->parseOrbitData($orbitData);
    }

    public function getOrbitsForPlanet(Planet $planet): array
    {
        $orbits = [];
        while (true) {
            if ($planet->getOrbits() === self::ORBIT_CENTER) {
                break;
            }

            $planet = $this->getPlanet($planet->getOrbits());

            $orbits[] = $planet->getName();

            if (\count($orbits) > 1000) {
                throw new \Exception('Recursion alert!');
            }
        }
        return $orbits;
    }

    public function countTotalOrbits()
    {
        $orbits = 0;
        foreach ($this->planets as $planet) {
            $orbits += $this->countOrbitsForPlanet($planet);
        }

        return $orbits;
    }

    public function countOrbitsForPlanet(Planet $planet): int
    {
        return \count($this->getOrbitsForPlanet($planet));
    }

    public function getPlanet(string $name): Planet
    {
        if (!array_key_exists($name, $this->planets)) {
            throw new \Exception('Unknown planet: ' . $name);
        }

        return $this->planets[$name];
    }

    public function calculateTransfersBetween(Planet $planetA, Planet $planetB)
    {
        $orbitsForPlanetA = $this->getOrbitsForPlanet($planetA);
        $orbitsForPlanetB = $this->getOrbitsForPlanet($planetB);

        $commonPlanets = array_intersect($orbitsForPlanetA, $orbitsForPlanetB);
        // Substract 1 of the intersecting planets because you still need it to orbit around it.
        $commonOrbits = \count($commonPlanets) - 1;

        return
            // traveling towards COM
            (\count($orbitsForPlanetA) - 1 - $commonOrbits)
            // traveling away from COM, towards Santa
            + (\count($orbitsForPlanetB) - 1 - $commonOrbits);
    }

    private function parseOrbitData(array $orbitData)
    {
        foreach ($orbitData as $item) {
            [ $orbits, $name ] = explode(')', $item);
            $this->planets[$name] = new Planet($name, $orbits);
        }
    }
}
