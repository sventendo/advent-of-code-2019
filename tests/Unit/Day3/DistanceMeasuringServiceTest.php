<?php
namespace Sventendo\AdventOfCode2019\Tests\Unit\Day3;

use PHPUnit\Framework\TestCase;
use Sventendo\AdventOfCode2019\Day3\DistanceMeasuringService;

class DistanceMeasuringServiceTest extends TestCase
{
    /** @var DistanceMeasuringService */
    protected $subject;

    public function setUp()
    {
        $this->subject = new DistanceMeasuringService();
    }

    public function testDistance()
    {
        $this->assertEquals('5', $this->subject->manhattanDistance('[-2, 3]'));
    }
}
