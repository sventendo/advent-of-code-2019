<?php
namespace Sventendo\AdventOfCode2019\Day1;

class FuelCalculator
{
    public function calculate(int $mass): int
    {
        return floor($mass / 3) - 2;
    }

    public function calculateRecursive(int $mass): int
    {
        $fuel = 0;

        do {
            $fuelAdded = $this->calculate($mass);
            $fuelAdded = max($fuelAdded, 0);
            $mass = $fuelAdded;
            $fuel += $fuelAdded;
        } while ($fuelAdded > 0);

        return $fuel;
    }
}
