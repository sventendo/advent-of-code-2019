<?php
namespace Sventendo\AdventOfCode2019;

use Sventendo\AdventOfCode2019\Day11\Hull;
use Sventendo\AdventOfCode2019\Day11\Robot;
use Sventendo\AdventOfCode2019\Day11\IntcodeComputer;

class Day11 extends Day
{
    /** @var IntcodeComputer */
    protected $intcodeComputer;

    public function firstPuzzle($input): string
    {
        $this->parseInput($input);

        $intcodeComputer = new IntcodeComputer($this->input, [ '0' ]);

        $hull = new Hull();
        $robot = new Robot(new Vector(0, 0), true);

        $steps = 0;

        $hull->print($robot) . PHP_EOL;

        while (true) {
            print 'Robot at position: ' . $robot->getPosition()->__toString() . PHP_EOL;
            $response = $intcodeComputer->run(
                function () use ($hull, $robot) {
                    return $hull->getColor($robot->getPosition());
                }
            );
            if ($response->getStatusCode() === 4) {
                if (array_search($response->getValue(), [ '0', '1' ], true) === false) {
                    throw new \Exception('Unexpected output: ' . $response->getValue());
                }

                if ($robot->getMode() === Robot::MODE_PAINT) {
                    $hull->paint($robot->getPosition(), $response->getValue());
                    $robot->toggleMode();
                }

                if ($robot->getMode() === Robot::MODE_TURN) {
                    if ($response->getValue() === '0') {
                        $robot->turnLeft();
                    } else {
                        $robot->turnRight();
                    }
                    $robot->move();
                    print 'Robot at position: ' . $robot->getPosition()->__toString() . PHP_EOL;
                    $intcodeComputer->addInput($hull->getColor($robot->getPosition()));
                    $robot->toggleMode();
                }
            }

            if ($response->getStatusCode() === 99) {
                $hull->print($robot);
                return (string) $hull->countPanelsPainted();
            }

//            $hull->printData();
            $hull->print($robot);

            $steps++;
            if ($steps === 20) {
                return '20 steps taken.';
            }
        }
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        $this->intcodeComputer = new IntcodeComputer($this->input, [ 2 ]);

        return (string) $this->intcodeComputer->run()->getValue();
    }

    protected function parseInput(string $input): void
    {
        $this->input = $this->inputParser->listToArray($input, false);
    }
}
