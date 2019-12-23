<?php
namespace Sventendo\AdventOfCode2019;


class Math
{
    public static function lcm($a, $b)
    {
        if ($a === 0 || $b === 0) {
            return 0;
        }
        $r = ($a * $b) / self::gcd($a, $b);

        return abs($r);
    }

    public static function gcd($a, $b)
    {
        while ($b !== 0) {
            $t = $b;
            $b = $a % $b;
            $a = $t;
        }

        return $a;
    }
}
