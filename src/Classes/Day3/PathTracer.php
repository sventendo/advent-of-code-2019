<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day3;

use Sventendo\AdventOfCode2019\Vector;

class PathTracer
{
    /** @var array */
    protected $directionCodes;

    public function __construct(array $directionCodes)
    {
        $this->directionCodes = $directionCodes;
    }

    public function trace(): array
    {
        $vector = new Vector();
        $coordinates = [ json_encode($vector) ];

        foreach ($this->directionCodes as $directionCode) {
            $direction = substr($directionCode, 0, 1);
            $steps = (int) substr($directionCode, 1);

            for ($step = 0; $step < $steps; $step++) {
                $vector = clone($vector);

                switch ($direction) {
                    case 'U':
                        $vector->up();
                        break;
                    case 'R':
                        $vector->right();
                        break;
                    case 'D':
                        $vector->down();
                        break;
                    case 'L':
                        $vector->left();
                        break;
                    default:
                        throw new \Exception('Unknown direction: ' . $direction);
                }

                $coordinates[] = json_encode($vector);
            }
        }

        return $coordinates;
    }
}
