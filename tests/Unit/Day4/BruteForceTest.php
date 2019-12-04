<?php
namespace Sventendo\AdventOfCode2019\Tests\Unit\Day4;

use PHPUnit\Framework\TestCase;
use Sventendo\AdventOfCode2019\Day4\BruteForce;

class BruteForceTest extends TestCase
{
    public function testInValid()
    {
        $subject = new BruteForce();

        $this->assertTrue($subject->isValid('112233'));
        $this->assertTrue($subject->isValid('000000'));
        $this->assertFalse($subject->isValid('112232'));

        $this->assertTrue($subject->isValid('112233', true));
        $this->assertFalse($subject->isValid('123444', true));
        $this->assertTrue($subject->isValid('111122', true));
    }

    public function testCreatesTripletsPattern()
    {
        $subject = new BruteForce();

        $this->assertEquals('/(3{3}|5{3})/', $subject->createTripletsPattern([ 3, 5 ]));
        $this->assertEquals('/(3{3})/', $subject->createTripletsPattern([ 3 ]));
    }
}
