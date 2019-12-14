<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day11;

class Response
{
    public const STATUS_CODE_OUTPUT = 4;
    public const STATUS_CODE_HALT = 99;

    /** @var int */
    protected $statusCode;
    /** @var string */
    protected $value;

    public function __construct(int $statusCode, string $value, array $output)
    {
        $this->statusCode = $statusCode;
        $this->value = $value;
        $this->output = $output;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getOutput(): array
    {
        return $this->output;
    }
}
