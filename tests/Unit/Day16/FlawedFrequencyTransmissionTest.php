<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Tests\Unit\Day16;

use PHPUnit\Framework\TestCase;
use Sventendo\AdventOfCode2019\Day16\FlawedFrequencyTransmission;

class FlawedFrequencyTransmissionTest extends TestCase
{
    public function testGetSingleHashValue()
    {
        $hash = '12345678';
        $subject = new FlawedFrequencyTransmission($hash);

        $values = str_split($hash);
        $this->assertEquals(4, $subject->getSingleHashValue($values, 1));
        $this->assertEquals(8, $subject->getSingleHashValue($values, 2));
    }

    public function testGenerateHash()
    {
        $subject = new FlawedFrequencyTransmission('');

        $this->assertEquals('48226158', $subject->generateHash('12345678'));
        $this->assertEquals('34040438', $subject->generateHash('48226158'));
        $this->assertEquals('03415518', $subject->generateHash('34040438'));
        $this->assertEquals('01029498', $subject->generateHash('03415518'));
    }

    public function testGenerateSecondHalf()
    {
        $subject = new FlawedFrequencyTransmission('');

        $secondHalf = function (string $string) {
            return substr($string, strlen($string) / 2);
        };

        $hash = '12345678';
        for ($i = 0; $i < 5; $i++) {
            $generatedSecondHalf = $subject->generateSecondHalfOfHashFromSecondHalfOfHash($secondHalf($hash));
            $hash = $subject->generateHash($hash);
            $this->assertEquals($generatedSecondHalf, $secondHalf($hash));
        }
    }

    public function testGetMultipliedHash()
    {
        $subject = new FlawedFrequencyTransmission('1234');
        $this->assertEquals('123412341234', $subject->getMultipliedHash(3));
    }

    public function testRun4()
    {
        $subject = new FlawedFrequencyTransmission('12345678');

        $subject->run(4);

        $this->assertEquals('01029498', substr($subject->getLastHash(), 0, 8));
    }

    public function testRun100()
    {
        $subject = new FlawedFrequencyTransmission('80871224585914546619083218645595');

        $subject->run(100);

        $this->assertEquals('24176176', substr($subject->getLastHash(), 0, 8));
    }

    /**
     * @dataProvider getGetFactorExamples
     */
    public function testGetFactor(int $patternFactor, int $position, int $expected)
    {
        $subject = new FlawedFrequencyTransmission('');
        $this->assertEquals($expected, $subject->getFactor($patternFactor, $position));
    }

    public function getGetFactorExamples()
    {
        return [
            [ 1, 0, 1 ],
            [ 1, 1, 0 ],
            [ 1, 2, -1 ],
            [ 1, 3, 0 ],
            [ 1, 4, 1 ],
            [ 2, 0, 0 ],
            [ 2, 1, 1 ],
            [ 2, 2, 1 ],
        ];
    }

    public function testGenerateSecondHalfFromSecondHalf()
    {
        $subject = new FlawedFrequencyTransmission('');
        $this->assertEquals('8642', $subject->generateSecondHalfOfHashFromSecondHalfOfHash('2222'));
        $this->assertEquals('0262', $subject->generateSecondHalfOfHashFromSecondHalfOfHash('8642'));
        $this->assertEquals('65306158', $subject->generateSecondHalfOfHashFromSecondHalfOfHash('12345678'));
    }

    /**
     * @dataProvider getMultipliedHashesExample
     */
    public function testMultipliedHashes(string $hash, int $phases, int $multiplier, string $expected)
    {
        $subject = new FlawedFrequencyTransmission($hash);
        $this->assertEquals($expected, $subject->runForHashInSecondHalf($phases, $multiplier));
    }

    public function getMultipliedHashesExample()
    {
        return [
            [ '03036732577212944063491565474664', 100, 10000, '84462026' ],
            [ '02935109699940807407585447034323', 100, 10000, '78725270' ],
            [ '03081770884921959731165446850517', 100, 10000, '53553731' ],
        ];
    }
}
