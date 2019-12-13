<?php
namespace Sventendo\AdventOfCode2019\Day10;

class DeathStar
{
    /** @var StarMap */
    protected $starMap;
    /** @var array[] */
    protected $raysPerAngle;

    public function __construct(StarMap $starMap, array $raysPerAngle)
    {
        // Sort all planets for each angle by distance
        array_walk(
            $raysPerAngle,
            function (array &$rays) {
                usort(
                    $rays,
                    function (Ray $rayA, Ray $rayB) {
                        return $rayA->getDistance() <=> $rayB->getDistance();
                    }
                );
            }
        );

        $this->starMap = $starMap;
        $this->raysPerAngle = array_values($raysPerAngle);

    }

    public function spinLaser(int $planetsToVaporize): Ray
    {
        $planetsVaporized = 0;
        $rayIndex = 0;

        /** @var Ray $planetVaporized */
        $planetVaporized = null;

        while ($planetsVaporized < $planetsToVaporize) {
            $rayIndex = $rayIndex % \count($this->raysPerAngle);
            if (\count($this->raysPerAngle[$rayIndex]) !== 0) {
                $planetVaporized = array_shift($this->raysPerAngle[$rayIndex]);
                $planetsVaporized++;
            }
            $rayIndex++;
        }

        return $planetVaporized;
    }
}
