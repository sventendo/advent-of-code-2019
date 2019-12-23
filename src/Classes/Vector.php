<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019;

class Vector implements \JsonSerializable
{
    public const DIRECTION_UP = 0;
    public const DIRECTION_RIGHT = 1;
    public const DIRECTION_DOWN = 2;
    public const DIRECTION_LEFT = 3;

    /** @var int */
    protected $x;
    /** @var int */
    protected $y;

    public function __construct(int $x = 0, int $y = 0)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function addVector(Vector $vector)
    {
        $this->x += $vector->getX();
        $this->y += $vector->getY();
    }

    /**
     * This was a _lot_ of trial and error.
     * Angles starting at 0 to the "right" need to start at 0 in the direction of "up", also they
     * need to increase clockwise, instead of anti-clockwise.
     * Since the coordinate plain starts at y = 0 and increases downwards instead of upwards,
     * the angles are in effect mirrored (and hence increasing clockwise).
     *
     * @param Vector $vector
     * @return float
     */
    public function angleTo(Vector $vector): float
    {
        $angle = atan2($vector->getY() - $this->y, $vector->getX() - $this->x) * 180 / pi();

        // Rotate by 90 degrees, so 0 points "up".
        $angle += 90;

        // Ensure it's a positive angle.
        $angle = fmod($angle + 360, 360);

        return (float) $angle;
    }

    public function getLength()
    {
        return sqrt(pow(($this->x), 2) + pow(($this->y), 2));
    }

    public function distanceTo(Vector $vector)
    {
        return sqrt(pow(($this->x - $vector->getX()), 2) + pow(($this->y - $vector->getY()), 2));
    }

    public function dotProduct(Vector $vector)
    {
        return ($this->x * $vector->getX() + $this->y * $vector->getY());
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function up($steps = 1)
    {
        $this->y -= $steps;
    }

    public function right($steps = 1)
    {
        $this->x += $steps;
    }

    public function down($steps = 1)
    {
        $this->y += $steps;
    }

    public function left($steps = 1)
    {
        $this->x -= $steps;
    }

    public function move(int $direction): void
    {
        switch ($direction) {
            case self::DIRECTION_UP:
                $this->up();
                break;
            case self::DIRECTION_RIGHT:
                $this->right();
                break;
            case self::DIRECTION_DOWN:
                $this->down();
                break;
            case self::DIRECTION_LEFT:
                $this->left();
                break;
            default:
                break;
        }
    }

    public function __toString()
    {
        return $this->x . ',' . $this->y;
    }

    public function jsonSerialize()
    {
        return [ $this->x, $this->y ];
    }

    public function getStringValue()
    {
        return $this->y . '|' . $this->x;
    }
}
