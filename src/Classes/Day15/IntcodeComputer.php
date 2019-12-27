<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day15;

class IntcodeComputer
{
    private const MODE_POSITION = '0';
    private const MODE_IMMEDIATE = '1';
    private const MODE_RELATIVE = '2';

    private const OPCODE_ADD = 1;
    private const OPCODE_MULTIPLY = 2;
    private const OPCODE_SET = 3;
    private const OPCODE_GET = 4;
    private const OPCODE_JUMP_IF_TRUE = 5;
    private const OPCODE_JUMP_IF_FALSE = 6;
    private const OPCODE_LESS_THAN = 7;
    private const OPCODE_EQUALS = 8;
    private const OPCODE_ADJUST_RELATIVE_BASE = 9;
    private const OPCODE_EXIT = 99;
    /** @var array */
    private $software;
    /** @var int */
    private $pointer = 0;
    /** @var array */
    private $output = [];
    /** @var int */
    private $relativeBase = 0;
    /** @var bool */
    private $debug = false;
    /** @var \Closure */
    private $inputCallback;

    public function __construct(array $software, \Closure $inputCallback, bool $debug = false)
    {
        $this->software = $software;
        $this->inputCallback = $inputCallback;
        $this->debug = $debug;
    }

    public function run(): Response
    {
        for ($cycle = 0; $cycle < 1000000; $cycle++) {
            $instruction = $this->normalizeInstruction($this->software[$this->pointer]);
            $opcode = $this->getOpcode($instruction);
            if ($this->debug) {
                print (json_encode($this->software) . PHP_EOL);
                print ('Running ' . $instruction . ' with relative base ' . $this->relativeBase . PHP_EOL);
                print ('Output: ' . json_encode($this->output));
                print PHP_EOL;
            }
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
                    $this->set($instruction, $this->software[$this->pointer + 1]);
                    $this->pointer += 2;
                    break;
                case self::OPCODE_GET:
                    $output = (int) $this->get($instruction, $this->software[$this->pointer + 1]);
                    $this->pointer += 2;
                    return new Response(self::OPCODE_GET, $output);
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
                case self::OPCODE_ADJUST_RELATIVE_BASE:
                    $this->adjustRelativeBase($instruction, $this->software[$this->pointer + 1]);
                    $this->pointer += 2;
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
        $target = $this->getPosition($parameterC, $opcode[-5]);
        $this->software[(int) $target] = (string) ((int) $valueA + (int) $valueB);
    }

    public function multiply(string $opcode, string $parameterA, string $parameterB, string $parameterC): void
    {
        $valueA = $this->getValue($parameterA, $opcode[-3]);
        $valueB = $this->getValue($parameterB, $opcode[-4]);
        $target = $this->getPosition($parameterC, $opcode[-5]);

        $this->software[$target] = (string) ((int) $valueA * (int) $valueB);
    }

    public function set(string $opcode, string $parameterA): void
    {
        $position = $this->getPosition($parameterA, $opcode[-3]);
        $this->software[(int) $position] = (string) ($this->inputCallback)();
    }

    public function get(string $opcode, string $parameterA): string
    {
        return $this->getValue($parameterA, $opcode[-3]);
    }

    public function jumpIfTrue(string $opcode, string $parameterA = '0', string $parameterB = '0'): void
    {
        $valueA = $this->getValue($parameterA, $opcode[-3]);
        $target = $this->getValue($parameterB, $opcode[-4]);

        if ((int) $valueA !== 0) {
            $this->pointer = (int) $target;
        } else {
            $this->pointer += 3;
        }
    }

    public function jumpIfFalse(string $opcode, string $parameterA = '0', string $parameterB = '0'): void
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
        $target = $this->getPosition($parameterC, $opcode[-5]);

        $this->software[(int) $target] = (int) $valueA < (int) $valueB ? '1' : '0';
    }

    public function equals(string $opcode, string $parameterA, string $parameterB, string $parameterC): void
    {
        $valueA = $this->getValue($parameterA, $opcode[-3]);
        $valueB = $this->getValue($parameterB, $opcode[-4]);
        $target = $this->getPosition($parameterC, $opcode[-5]);

        $this->software[(int) $target] = (int) $valueA === (int) $valueB ? '1' : '0';
    }

    public function adjustRelativeBase(string $opcode, string $parameterA)
    {
        $valueA = $this->getValue($parameterA, $opcode[-3]);

        $this->relativeBase += (int) $valueA;
    }

    public function getOpcode(string $instruction)
    {
        return (int) substr(trim($instruction), -2);
    }

    private function normalizeInstruction(string $instruction): string
    {
        $instruction = (string) $instruction;
        return str_pad($instruction, 5, '0', STR_PAD_LEFT);
    }

    private function getValue(string $parameter, string $mode): string
    {
        if ($mode === self::MODE_IMMEDIATE) {
            return $parameter;
        }

        $position = (int) $parameter;

        if ($mode === self::MODE_RELATIVE) {
            $position += $this->relativeBase;
        }

        if ($position < 0) {
            throw new \Exception('Invalid memory address: ' . $parameter);
        }

        // All memory address default to 0
        $this->software[$position] = $this->software[$position] ?? '0';

        return $this->software[$position];
    }

    private function getPosition(string $parameter, string $mode): int
    {
        $position = (int) $parameter;

        if ($mode === self::MODE_RELATIVE) {
            $position += $this->relativeBase;
        }

        if ($position < 0) {
            throw new \Exception('Invalid memory address: ' . $position);
        }

        return $position;
    }
}
