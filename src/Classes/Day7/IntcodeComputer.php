<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day7;

class IntcodeComputer
{
    private const MODE_POSITION = '0';
    private const MODE_IMMEDIATE = '1';

    private const OPCODE_ADD = 1;
    private const OPCODE_MULTIPLY = 2;
    private const OPCODE_SET = 3;
    private const OPCODE_GET = 4;
    private const OPCODE_JUMP_IF_TRUE = 5;
    private const OPCODE_JUMP_IF_FALSE = 6;
    private const OPCODE_LESS_THAN = 7;
    private const OPCODE_EQUALS = 8;
    private const OPCODE_EXIT = 99;
    /** @var array */
    private $software;
    /** @var int */
    private $pointer = 0;
    /** @var array */
    private $inputs;
    /** @var array */
    private $output = [];
    /** @var int */
    private $inputPointer = 0;

    public function __construct(array $software = [], array $inputs = [])
    {
        $this->software = $software;
        $this->inputs = $inputs;
    }

    public function addInput(string $input)
    {
        $this->inputs[] = $input;
    }

    public function run(bool $returnOnOutput = false): Response
    {
        for ($cycle = 0; $cycle < 1000; $cycle++) {
            $instruction = $this->normalizeInstruction($this->software[$this->pointer]);
            $opcode = $this->getOpcode($instruction);

            switch ($opcode) {
                case self::OPCODE_ADD:
                    $this->add($instruction, ...array_slice($this->software, $this->pointer + 1, 3));
                    $this->pointer += 4;
                    break;
                case self::OPCODE_MULTIPLY:
                    $this->multiply($instruction, ...array_slice($this->software, $this->pointer + 1, 3));
                    $this->pointer += 4;
                    break;
                case self::OPCODE_SET:
                    $this->set($this->software[$this->pointer + 1]);
                    $this->pointer += 2;
                    break;
                case self::OPCODE_GET:
                    $output = $this->get($instruction, $this->software[$this->pointer + 1]);
                    $this->pointer += 2;
                    $this->output[] = $output;
                    if ($returnOnOutput) {
                        return new Response(Response::STATUS_CODE_OUTPUT, $output);
                    }
                    break;
                case self::OPCODE_JUMP_IF_TRUE:
                    $this->jumpIfTrue($instruction, ...array_slice($this->software, $this->pointer + 1, 2));
                    break;
                case self::OPCODE_JUMP_IF_FALSE:
                    $this->jumpIfFalse($instruction, ...array_slice($this->software, $this->pointer + 1, 2));
                    break;
                case self::OPCODE_LESS_THAN:
                    $this->lessThan($instruction, ...array_slice($this->software, $this->pointer + 1, 3));
                    $this->pointer += 4;
                    break;
                case self::OPCODE_EQUALS:
                    $this->equals($instruction, ...array_slice($this->software, $this->pointer + 1, 3));
                    $this->pointer += 4;
                    break;
                case self::OPCODE_EXIT:
                    $lastOutputValue = $this->output[\count($this->output) - 1];
                    return new Response(Response::STATUS_CODE_HALT, $lastOutputValue);
                    break;
                default:
                    throw new \Exception('Invalid opcode: ' . $opcode);
            }
        }

        throw new \Exception('1000 cycles exceeded. Aborting.');
    }

    public function add(string $opcode, string $parameterA, string $parameterB, string $parameterC): void
    {
        $valueA = $this->getValue($parameterA, $opcode[-3]);
        $valueB = $this->getValue($parameterB, $opcode[-4]);
        $target = $parameterC;
        $this->software[(int) $target] = (string) ((int) $valueA + (int) $valueB);
    }

    public function multiply(string $opcode, string $parameterA, string $parameterB, string $parameterC): void
    {
        $valueA = $this->getValue($parameterA, $opcode[-3]);
        $valueB = $this->getValue($parameterB, $opcode[-4]);
        $target = $parameterC;

        $this->software[$target] = (string) ((int) $valueA * (int) $valueB);
    }

    public function set(string $position): void
    {
        $this->software[(int) $position] = (string) $this->getNextInput();
    }

    public function get(string $opcode, string $parameterA): string
    {
        return $this->getValue($parameterA, $opcode[-3]);
    }

    public function jumpIfTrue(string $opcode, string $parameterA, string $parameterB): void
    {
        $valueA = $this->getValue($parameterA, $opcode[-3]);
        $target = $this->getValue($parameterB, $opcode[-4]);

        if ((int) $valueA !== 0) {
            $this->pointer = (int) $target;
        } else {
            $this->pointer += 3;
        }
    }

    public function jumpIfFalse(string $opcode, string $parameterA, string $parameterB): void
    {
        $valueA = $this->getValue($parameterA, $opcode[-3]);
        $target = $this->getValue($parameterB, $opcode[-4]);

        if ((int) $valueA === 0) {
            $this->pointer = (int) $target;
        } else {
            $this->pointer += 3;
        }
    }

    public function lessThan(string $opcode, string $parameterA, string $parameterB, string $parameterC): void
    {
        $valueA = $this->getValue($parameterA, $opcode[-3]);
        $valueB = $this->getValue($parameterB, $opcode[-4]);
        $target = $parameterC;

        $this->software[(int) $target] = (int) $valueA < (int) $valueB ? 1 : 0;
    }

    public function equals(string $opcode, string $parameterA, string $parameterB, string $parameterC): void
    {
        $valueA = $this->getValue($parameterA, $opcode[-3]);
        $valueB = $this->getValue($parameterB, $opcode[-4]);
        $target = $parameterC;

        $this->software[(int) $target] = (int) $valueA === (int) $valueB ? 1 : 0;
    }

    public function getOpcode(string $instruction)
    {
        return (int) substr(trim($instruction), -2);
    }

    protected function getNextInput(): string
    {
        if (!array_key_exists($this->inputPointer, $this->inputs)) {
            throw new \Exception('Invalid input pointer: ' . ($this->inputPointer));
        }

        // Return value at current input pointer and then increase.
        return (string) $this->inputs[$this->inputPointer++];
    }

    private function normalizeInstruction(string $instruction): string
    {
        $instruction = (string) $instruction;
        return str_pad($instruction, 5, '0', STR_PAD_LEFT);
    }

    private function getValue(string $parameter, string $mode)
    {
        if ($mode === self::MODE_IMMEDIATE) {
            return $parameter;
        }

        if ($mode === self::MODE_POSITION) {
            return $this->software[(int) $parameter];
        }

        throw new \Exception('Invalid parameter mode: ' . $mode);
    }
}
