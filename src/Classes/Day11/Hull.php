<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day11;

use Sventendo\AdventOfCode2019\Vector;

class Hull
{
    /** @var array[] */
    protected $panels = [ [ 0 ] ];
    protected $panelsPainted = [];

    public function getColor(Vector $position)
    {
        $this->initializePanel($position);
        $color = $this->panels[$position->getY()][$position->getX()];
        print 'Color at panel ' . $position->__toString() . ' is ' . ($color === 0 ? 'black' : 'white') . PHP_EOL;


        return $color;
    }

    public function paint(Vector $position, int $color)
    {
        $this->initializePanel($position);

        $this->panels[$position->getY()][$position->getX()] = $color;

        $this->panelsPainted[$position->getStringValue()] = $color;
    }

    public function countPanelsPainted()
    {
        return \count($this->panelsPainted);
    }

    public function print(Robot $robot)
    {
        $leftBorder = min(
            array_map(
                function (array $row) {
                    return min(array_keys($row));
                },
                $this->panels
            )
        );
        $rightBorder = max(
            array_map(
                function (array $row) {
                    return max(array_keys($row));
                },
                $this->panels
            )
        );
        $upperBorder = min(array_keys($this->panels));
        $lowerBorder = max(array_keys($this->panels));

        $canvas = [ [] ];
        for ($y = 0; $y <= $lowerBorder - $upperBorder; $y++) {
            $canvas[$y] = array_fill(0, $rightBorder - $leftBorder + 1, '.');
        }

        foreach ($this->panelsPainted as $position => $color) {
            [ $y, $x ] = explode('|', $position);
            $y = (int) $y;
            $x = (int) $x;
            if (!array_key_exists($y - $upperBorder, $canvas)) {
                throw new \Exception('Value out of bounds: ' . ($y - $upperBorder));
            }
            $canvas[$y - $upperBorder][$x - $leftBorder] = $color === 1 ? '▓' : '░';
        }

        $canvas[$robot->getPosition()->getY() - $upperBorder][$robot->getPosition()->getX() - $leftBorder] =
            $robot->getIcon();

        foreach ($canvas as $row) {
            print implode('', $row) . PHP_EOL;
        }
        print PHP_EOL;
    }

    public function printData()
    {
        print json_encode($this->panels) . PHP_EOL;
    }

    private function initializePanel(Vector $position)
    {
        $this->panels[$position->getY()] = $this->panels[$position->getY()] ?? [];
        $this->panels[$position->getY()][$position->getX()] = $this->panels[$position->getY()][$position->getX()] ?? 0;
    }
}
