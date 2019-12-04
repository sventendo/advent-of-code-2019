<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day4;

class BruteForce
{
    /** @var int */
    protected $from;
    /** @var int */
    protected $to;

    public function __construct(int $from = 0, int $to = 0)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function crack($strict = false): array
    {
        $candidates = [];

        for ($password = $this->from; $password < $this->to; $password++) {
            $candidate = (string) $password;

            if ($this->isValid($candidate, $strict)) {
                $candidates[] = $candidate;
            }
        }

        return $candidates;
    }

    public function isValid(string $password, bool $strict = false)
    {
        if (strlen($password) !== 6) {
            return false;
        }

        if (!preg_match_all('/(11|22|33|44|55|66|77|88|99|00)/', $password, $matchesForDoubles)) {
            return false;
        }
        $doublesFound = array_unique($matchesForDoubles[1]);

        if (!$this->ascendingOrder($password)) {
            return false;
        }

        $doublesOfKind = array_map(
            function ($double) {
                return $double[0];
            },
            $doublesFound
        );

        if ($strict) {
            $tripletsPattern = $this->createTripletsPattern($doublesOfKind);
            if (preg_match_all($tripletsPattern, $password, $matchesForTriplets)) {
                if (\count(array_unique($matchesForTriplets[1])) === \count($doublesFound)) {
                    return false;
                }
            }
        }

        return true;
    }

    private function ascendingOrder(string $password): bool
    {
        $characters = str_split($password);
        sort($characters);

        if (implode('', $characters) !== $password) {
            return false;
        }

        return true;
    }

    public function createTripletsPattern(array $doublesOfKind): string
    {
        $pattern = '';
        foreach ($doublesOfKind as $value) {
            $pattern .= $value . '{3}|';
        }

        return '/(' . rtrim($pattern, '|') . ')/';
    }
}
