<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day2;

class IntcodeComputer
{
    private $commands;

    public function __construct(array $values)
    {
        $this->commands = array_chunk($values, 4);
    }

    public function run()
    {
        foreach (array_keys($this->commands) as $index) {
            // Since the underlying array changes on every command,
            // we get a fresh command every time.
            $command = $this->commands[$index];
            if ($command[0] === 99) {
                break;
            }

            $this->runCommand($command);
        }
    }

    public function setValue(int $position, int $value): void
    {
        $commandIndex = (int) floor($position / 4);
        $commandPosition = $position % 4;

        $this->commands[$commandIndex][$commandPosition] = $value;
    }

    public function getValue(int $position): int
    {
        $commandIndex = (int) floor($position / 4);
        $commandPosition = $position % 4;

        return $this->commands[$commandIndex][$commandPosition];
    }

    public function getValueList(): array
    {
        return array_merge(...$this->commands);
    }

    private function runCommand(array $command)
    {
        switch ($command[0]) {
            case 1:
                $this->setValue($command[3], $this->getValue($command[1]) + $this->getValue($command[2]));
                break;
            case 2:
                $this->setValue($command[3], $this->getValue($command[1]) * $this->getValue($command[2]));
                break;
            default:
                break;
        }
    }
}
