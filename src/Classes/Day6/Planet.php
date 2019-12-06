<?php
namespace Sventendo\AdventOfCode2019\Day6;

class Planet
{
    /** @var string */
    protected $name;
    /** @var string */
    protected $orbits;

    public function __construct(string $name, string $orbits)
    {
        $this->name = $name;
        $this->orbits = $orbits;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOrbits(): string
    {
        return $this->orbits;
    }
}
