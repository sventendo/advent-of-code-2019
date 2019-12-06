<?php
namespace Sventendo\AdventOfCode2019\Tests\Unit\Day6;

use PHPUnit\Framework\TestCase;
use Sventendo\AdventOfCode2019\Day6\OrbitCounter;

class OrbitCounterTest extends TestCase
{
    public function testCountTotalOrbits()
    {
        $data = [
            'COM)B',
            'B)C',
            'C)D',
            'D)E',
            'E)F',
            'B)G',
            'G)H',
            'D)I',
            'E)J',
            'J)K',
            'K)L',
        ];
        $subject = new OrbitCounter($data);

        $planet = $subject->getPlanet('D');
        $this->assertEquals(3, $subject->countOrbitsForPlanet($planet));
        $this->assertEquals(42, $subject->countTotalOrbits());
    }

    public function testCalculateTransfers()
    {
        $data = [
            'COM)B',
            'B)C',
            'C)D',
            'D)E',
            'E)F',
            'B)G',
            'G)H',
            'D)I',
            'E)J',
            'J)K',
            'K)L',
            'K)YOU',
            'I)SAN',
        ];

        $subject = new OrbitCounter($data);

        $you = $subject->getPlanet('YOU');
        $santa = $subject->getPlanet('SAN');

        $this->assertEquals(4, $subject->calculateTransfersBetween($you, $santa));
    }
}
