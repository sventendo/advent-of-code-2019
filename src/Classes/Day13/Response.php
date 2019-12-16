<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day13;

class Response
{
    public const STATUS_CODE_OUTPUT = 4;
    public const STATUS_CODE_HALT = 99;

    /** @var int */
    protected $statusCode;
    /** @var string */
    protected $tile;

    public function __construct(int $statusCode, Tile $tile = null)
    {
        $this->statusCode = $statusCode;
        $this->tile = $tile;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getTile(): ?Tile
    {
        return $this->tile;
    }
}
