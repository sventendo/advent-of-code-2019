<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day11;

use Sventendo\AdventOfCode2019\Vector;

class PaintJob
{
    /** @var Hull */
    protected $hull;
    /** @var Robot */
    protected $robot;

    public function start(array $input, int $initialColor)
    {
        $hull = new Hull($initialColor);
        $this->hull = $hull;
        $robot = new Robot(new Vector(0, 0));
        $this->robot = $robot;

        $intcodeComputer = new IntcodeComputer(
            $input,
            function () use ($hull, $robot) {
                return $this->hull->getColor($robot->getPosition());
            }
        );

        while (true) {
            $response = $intcodeComputer->run();
            if ($response->getStatusCode() === 4) {
                if (array_search($response->getValue(), [ '0', '1' ], true) === false) {
                    throw new \Exception('Unexpected output: ' . $response->getValue());
                }

                if ($robot->getMode() === Robot::MODE_PAINT) {
                    $this->hull->paint($robot->getPosition(), (int) $response->getValue());
                    $robot->toggleMode();
                } elseif ($robot->getMode() === Robot::MODE_TURN) {
                    if ($response->getValue() === '0') {
                        $robot->turnLeft();
                    } elseif ($response->getValue() === '1') {
                        $robot->turnRight();
                    }
                    $robot->move();
                    $robot->toggleMode();
                }
            }

            if ($response->getStatusCode() === 99) {
                return;
            }
        }
    }

    public function print()
    {
        $this->hull->print($this->robot);
    }

    public function countPanelsPointed()
    {
        return (string) $this->hull->countPanelsPainted();
    }
}
