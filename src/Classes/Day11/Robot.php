<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day11;

use Sventendo\AdventOfCode2019\Vector;

class Robot
{
    public const DIRECTION_UP = 0;
    public const DIRECTION_RIGHT = 1;
    public const DIRECTION_DOWN = 2;
    public const DIRECTION_LEFT = 3;

    public const MODE_PAINT = 0;
    public const MODE_TURN = 1;

    /** @var Vector */
    protected $position;

    protected $direction = self::DIRECTION_UP;

    protected $mode;

    protected $debug;

    public function __construct(Vector $startingPosition, bool $debug = false)
    {
        $this->position = $startingPosition;
        $this->mode = self::MODE_PAINT;
        $this->debug = $debug;
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
        switch ($this->direction) {
            case self::DIRECTION_UP:
                $this->print('Moving up.');
                $this->position->up();
                break;
            case self::DIRECTION_RIGHT:
                $this->print('Moving right.');
                $this->position->right();
                break;
            case self::DIRECTION_DOWN:
                $this->print('Moving down.');
                $this->position->down();
                break;
            case self::DIRECTION_LEFT:
                $this->print('Moving left.');
                $this->position->left();
                break;
            default:
                break;
        }
    }

    public function getPosition(): Vector
    {
        return $this->position;
    }

    public function toggleMode()
    {
        $this->mode = ($this->mode + 1) % 2;
    }

    public function getMode(): int
    {
        return $this->mode;
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

    protected function print(string $message)
    {
        if ($this->debug) {
            print $message . PHP_EOL;
        }
    }
}
