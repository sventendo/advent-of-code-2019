<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019;

use Sventendo\AdventOfCode2019\Day13\IntcodeComputer;
use Sventendo\AdventOfCode2019\Day13\Response;
use Sventendo\AdventOfCode2019\Day13\Screen;
use Sventendo\AdventOfCode2019\Day13\Tile;

class Day13 extends Day
{
    public function firstPuzzle($input): string
    {
        $this->parseInput($input);

        $screen = new Screen();
        $intcodeComputer = new IntcodeComputer(
            $this->input,
            function () {
                return;
            }
        );

        while (true) {
            $response = $intcodeComputer->run();

            if ($response->getStatusCode() === Response::STATUS_CODE_HALT) {
                return (string) $screen->countTiles(Tile::TYPE_BLOCK);
            }

            $screen->addTile($response->getTile());
        }
    }

    public function secondPuzzle($input): string
    {
        $this->parseInput($input);
        $this->input[0] = '2';

        $screen = new Screen();
        $intcodeComputer = new IntcodeComputer(
            $this->input,
            function () use ($screen, &$initialized) {
                $ballPosition = $screen->getBall()->getX();
                $paddlePosition = $screen->getPaddle()->getX();
                return $ballPosition <=> $paddlePosition;
            }
        );

        while (true) {
            $response = $intcodeComputer->run();

            if ($response->getStatusCode() === Response::STATUS_CODE_HALT) {
                return (string) $screen->countTiles(Tile::TYPE_BLOCK);
            }

            if ($response->getTile()->getX() === -1 && $response->getTile()->getY() === 0) {
                $screen->setHighscore($response->getTile()->getType());
                if ($screen->getHighscore() > 0 && $screen->countTiles(Tile::TYPE_BLOCK) === 0) {
                    break;
                }
            } else {
                $screen->addTile($response->getTile());
            }
        }

        return (string) $screen->getHighscore();
    }

    protected function parseInput(string $input): void
    {
        $this->input = $this->inputParser->listToArray($input, false);
    }
}
