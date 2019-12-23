<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day15;

use Sventendo\AdventOfCode2019\Vector;

class Droid
{
    public const DIRECTION_UP = 0;
    public const DIRECTION_RIGHT = 1;
    public const DIRECTION_DOWN = 2;
    public const DIRECTION_LEFT = 3;

    /** @var Vector */
    protected $position;
    /** @var int */
    protected $direction = self::DIRECTION_UP;
    /** @var bool */
    protected $debug;
    /** @var bool */
    protected $detour = false;
    /** @var string[] */
    private $positionMemory = [];

    public function __construct(bool $debug = false)
    {
        $this->debug = $debug;
        $this->position = new Vector(0, 0);
    }

    public function isDetour(): bool
    {
        return $this->detour;
    }

    public function setDetour(bool $detour): void
    {
        $this->detour = $detour;
    }

    public function getDirection(): int
    {
        return $this->direction;
    }

    public function getCompassOrientation(): int
    {
        $map = [ 1, 4, 2, 3 ];
        return $map[$this->direction];
    }

    public function getPosition(): Vector
    {
        return $this->position;
    }

    public function turnRight(): void
    {
        $this->print('Turning right.');
        $this->direction = ($this->direction + 1) % 4;
    }

    public function turnLeft(): void
    {
        $this->print('Turning left.');
        $this->direction = ($this->direction + 3) % 4;
    }

    public function move(): void
    {
        $this->position->move($this->direction);
        $this->addToPositionMemory($this->position);


        switch ($this->direction) {
            case self::DIRECTION_UP:
                $this->print('Moving up.');
                break;
            case self::DIRECTION_RIGHT:
                $this->print('Moving right.');
                break;
            case self::DIRECTION_DOWN:
                $this->print('Moving down.');
                break;
            case self::DIRECTION_LEFT:
                $this->print('Moving left.');
                break;
            default:
                break;
        }
    }

    public function getNextPosition(): Vector
    {
        $newPosition = clone($this->position);
        $newPosition->move($this->direction);

        return $newPosition;
    }

    public function getIcon(): string
    {
        switch ($this->direction) {
            case self::DIRECTION_UP:
                return '^';
            case self::DIRECTION_RIGHT:
                return '>';
            case self::DIRECTION_DOWN:
                return 'v';
            case self::DIRECTION_LEFT:
                return '<';
            default:
                return '.';
        }
    }

    public function setDirection(int $direction)
    {
        $this->direction = $direction;
    }

    public function wasHereStepsAgo(Vector $testPosition): int
    {
        $memoryPosition = array_search($testPosition->getStringValue(), $this->positionMemory);

        if ($memoryPosition === false) {
            return 99;
        }

        return $memoryPosition;
    }

    protected function print(string $message)
    {
        if ($this->debug) {
            print $message . PHP_EOL;
        }
    }

    private function addToPositionMemory(Vector $position): void
    {
        array_unshift($this->positionMemory, $position->getStringValue());

        $this->positionMemory = array_slice($this->positionMemory, 0, 20);
    }
}
