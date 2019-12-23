<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day15;

class Response
{
    public const STATUS_CODE_OUTPUT = 4;
    public const STATUS_CODE_HALT = 99;

    /** @var int */
    private $statusCode;
    /** @var int */
    private $value;

    public function __construct(int $statusCode, int $value)
    {
        $this->statusCode = $statusCode;
        $this->value = $value;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
