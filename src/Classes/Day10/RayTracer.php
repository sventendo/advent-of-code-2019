<?php
namespace Sventendo\AdventOfCode2019\Day10;

use Sventendo\AdventOfCode2019\Vector;

class RayTracer
{
    /** @var StarMap */
    private $starMap;

    /** @var array */
    private $dataForPosition = [];


    public function __construct(StarMap $starMap)
    {
        $this->starMap = $starMap;
    }

    public function trace()
    {
        for ($y = 0; $y < $this->starMap->getSizeY(); $y++) {
            for ($x = 0; $x < $this->starMap->getSizeX(); $x++) {
                $this->getDataForStarAtPosition($y, $x);
            }
        }
    }

    public function getStarWithMostRays()
    {
        $raysPerStar = $this->getRaysPerStars();

        return array_keys($raysPerStar)[0];
    }

    public function getRaysForStarWithMostRays(): array
    {
        $starWithMostRays = $this->getStarWithMostRays();

        return $this->getRaysForStar($starWithMostRays);
    }

    public function getRaysForStar(string $position): array
    {
        $angles = $this->dataForPosition[$position];

        uasort(
            $angles,
            /**
             * @param Ray[] $angleA
             * @param Ray[] $angleB
             * @return int
             */
            function (array $angleA, array $angleB) {
                return $angleA[0]->getAngle() <=> $angleB[0]->getAngle();
            }
        );

        return $angles;
    }

    private function getRaysPerStars(): array
    {
        $data = $this->dataForPosition;

        uasort(
            $data,
            function (array $positionA, array $positionB) {
                return \count($positionB) <=> \count($positionA);
            }
        );

        return $data;
    }

    private function getDataForStarAtPosition(int $starY, int $starX)
    {
        if ($this->starMap->hasStarAt($starY, $starX) === false) {
            return;
        }

        $starLocation = $starY . '|' . $starX;

        $this->dataForPosition[$starLocation] = [];

        for ($y = 0; $y < $this->starMap->getSizeY(); $y++) {
            for ($x = 0; $x < $this->starMap->getSizeX(); $x++) {
                if (($starY !== $y || $starX !== $x) && $this->starMap->hasStarAt($y, $x)) {
                    $ray = $this->getRayToStar(
                        $starY,
                        $starX,
                        $y,
                        $x
                    );
                    $this->dataForPosition[$starLocation][(string) $ray->getAngle()] =
                        $this->dataForPosition[$starLocation][(string) $ray->getAngle()] ?? [];
                    $this->dataForPosition[$starLocation][(string) $ray->getAngle()][] = $ray;
                }
            }
        }
    }

    private function getRayToStar($starY, $starX, $y, $x)
    {
        $vectorFromStar = new Vector($starX, $starY);
        $vectorToStar = new Vector($x, $y);
        $distance = $vectorFromStar->distanceTo($vectorToStar);
        $angle = $vectorFromStar->angleTo($vectorToStar);

        return new Ray(
            $distance,
            $angle,
            $y . '|' . $x
        );
    }
}
