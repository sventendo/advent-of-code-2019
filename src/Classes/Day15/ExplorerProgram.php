<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day15;

use Sventendo\AdventOfCode2019\Vector;

class ExplorerProgram
{
    /** @var bool */
    protected $debug;

    /** @var array */
    protected $software;

    /** @var Maze */
    protected $maze;

    public function __construct(array $software, bool $debug = false)
    {
        $this->software = $software;
        $this->debug = $debug;
    }

    public function run(): void
    {
        $this->maze = new Maze();
        $droid = new Droid();

        $intcodeComputer = new IntcodeComputer(
            $this->software,
            function () use ($droid) {
                return $droid->getCompassOrientation();
            }
        );

        $steps = 0;
        // Let the droid run around for a while and hope it gets a good map of the hallways.
        // 5.000 steps should be good.
        while (true && $steps < 5000) {
            $response = $intcodeComputer->run();

            if ($response->getValue() === Maze::TILE_FLOOR) {
                $droid->move();
                $this->maze->setFloor($droid->getPosition());
                $droid->setDirection($this->maze->getMostInterestingDirection($droid));
            } elseif ($response->getValue() === Maze::TILE_OXYGEN_SYSTEM) {
                $droid->move();
                $this->maze->setOxygenSystem(clone($droid->getPosition()));
                print sprintf(
                        'Oxygen System found at: %s after %d steps.',
                        $droid->getPosition()->getStringValue(),
                        $steps
                    ) . PHP_EOL . PHP_EOL;
            } else {
                $this->maze->setWall($droid->getNextPosition());
                $droid->setDirection($this->maze->getMostInterestingDirection($droid));
            }

            $steps++;
        }

        if ($this->debug) {
            $printer = new Printer($this->maze, $droid);
            $printer->print(false);
        }
    }

    public function getMaze(): Maze
    {
        return $this->maze;
    }
}
