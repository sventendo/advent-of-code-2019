<?php
namespace Sventendo\AdventOfCode2019\Day7;

class Response
{
    public const STATUS_CODE_OUTPUT = 4;
    public const STATUS_CODE_HALT = 99;

    /** @var int */
    protected $statusCode;
    /** @var string */
    protected $value;

    public function __construct(int $statusCode, string $value)
    {
        $this->statusCode = $statusCode;
        $this->value = $value;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
