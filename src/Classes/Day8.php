<?php
namespace Sventendo\AdventOfCode2019;

use Sventendo\AdventOfCode2019\Day8\Codec;

class Day8 extends Day
{
    /** @var Codec */
    protected $codec;

    public function __construct(InputParser $inputParser, Codec $codec)
    {
        parent::__construct($inputParser);
        $this->codec = $codec;
    }

    public function firstPuzzle($input): string
    {
        return (string) $this->codec->getChecksum($input, 25, 6);
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);

        $decoded = $this->codec->decode($input, 25, 6);

        return $this->makeReadable($decoded);
    }

    protected function parseInput(string $input): void
    {
        $this->input = $input;
    }

    protected function makeReadable($decoded): string
    {
        $decoded = str_replace('1', chr(219), $decoded);
        $decoded = str_replace('0', ' ', $decoded);

        return $decoded;
    }
}
