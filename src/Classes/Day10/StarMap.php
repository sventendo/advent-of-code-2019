<?php
namespace Sventendo\AdventOfCode2019\Day10;

class StarMap
{
    private const TOKEN_STAR = '#';

    /** @var array */
    private $rows = [];
    /** @var int */
    private $sizeX;
    /** @var int */
    private $sizeY;

    public function __construct(Array $rows)
    {
        foreach ($rows as $row) {
            if (trim($row) === '') {
                continue;
            }

            $this->rows[] = str_split($row);
        }

        $this->sizeX = \count($this->rows[0]);
        $this->sizeY = \count($this->rows);
    }

    public function hasStarAt(int $y, int $x)
    {
        return $this->rows[$y][$x] === self::TOKEN_STAR;
    }

    public function getSizeX(): int
    {
        return $this->sizeX;
    }

    public function getSizeY(): int
    {
        return $this->sizeY;
    }
}
