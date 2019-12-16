<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Tests\Unit\Day12;

use PHPUnit\Framework\TestCase;
use Sventendo\AdventOfCode2019\Day12\Orbit;
use Sventendo\AdventOfCode2019\Day12\Planet;
use Sventendo\AdventOfCode2019\Vector3d;

class OrbitTest extends TestCase
{
    public function test3Bodies()
    {
        $planetA = new Planet(new Vector3d(-1, 0, 2));
        $planetB = new Planet(new Vector3d(2, -10, -7));
        $planetC = new Planet(new Vector3d(4, -8, 8));
        $planetD = new Planet(new Vector3d(3, 5, -1));

        $orbit = new Orbit([ $planetA, $planetB, $planetC, $planetD ]);

        $orbit->step();

        $this->assertEquals($planetA->getPosition()->toArray(), [ 2, -1, 1 ], 'Planet A');
        $this->assertEquals($planetB->getPosition()->toArray(), [ 3, -7, -4 ], 'Planet B');
        $this->assertEquals($planetC->getPosition()->toArray(), [ 1, -7, 5 ], 'Planet C');
        $this->assertEquals($planetD->getPosition()->toArray(), [ 2, 2, 0 ], 'Planet D');

        $this->assertEquals($planetA->getVelocity()->toArray(), [ 3, -1, -1 ], 'Planet A');
        $this->assertEquals($planetB->getVelocity()->toArray(), [ 1, 3, 3 ], 'Planet B');
        $this->assertEquals($planetC->getVelocity()->toArray(), [ -3, 1, -3 ], 'Planet C');
        $this->assertEquals($planetD->getVelocity()->toArray(), [ -1, -3, 1 ], 'Planet D');


        $orbit->steps(9);

        $this->assertEquals($planetA->getPosition()->toArray(), [ 2, 1, -3 ], 'Planet A');
        $this->assertEquals($planetB->getPosition()->toArray(), [ 1, -8, 0 ], 'Planet B');
        $this->assertEquals($planetC->getPosition()->toArray(), [ 3, -6, 1 ], 'Planet C');
        $this->assertEquals($planetD->getPosition()->toArray(), [ 2, 0, 4 ], 'Planet D');

        $this->assertEquals($planetA->getVelocity()->toArray(), [ -3, -2, 1 ], 'Planet A');
        $this->assertEquals($planetB->getVelocity()->toArray(), [ -1, 1, 3 ], 'Planet B');
        $this->assertEquals($planetC->getVelocity()->toArray(), [ 3, 2, -3 ], 'Planet C');
        $this->assertEquals($planetD->getVelocity()->toArray(), [ 1, -1, -1 ], 'Planet D');

        $this->assertEquals(179, $orbit->getEnergy());
    }
}
