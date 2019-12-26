<?php declare(strict_types = 1);
namespace Sventendo\AdventOfCode2019\Day16;

class FlawedFrequencyTransmission
{
    /** @var string */
    private $inputHash;

    /** @var array */
    private $hashes = [];

    public function __construct(string $hash)
    {
        $this->inputHash = $hash;
    }

    public static function getFactor(int $patternFactor, $position): float
    {
        $map = [ 0, 1, 0, -1 ];

        return $map[((int) floor(($position + 1) / $patternFactor)) % 4];

        // This is lot cleverer but takes 50% longer to calculate :(
        // return (int) sin((floor(($position + 1) / $patternFactor)) * pi() / 2);
    }

    public function run(int $phases): void
    {
        $hash = $this->inputHash;
        for ($phase = 0; $phase < $phases; $phase++) {
            $hash = $this->generateHash($hash);
            $this->hashes[] = $hash;
        }
    }

    public function runForHashInSecondHalf(int $phases, int $multiplier): string
    {
        $position = (int) substr($this->inputHash, 0, 7);
        $multipliedHash = $this->getMultipliedHash($multiplier);
        if ($position < strlen($multipliedHash) / 2) {
            throw new \Exception('This solution only works for a substring in the second half of the hash.');
        }

        $relevantPartOfHash = substr($multipliedHash, $position);

        for ($phase = 0; $phase < $phases; $phase++) {
            $relevantPartOfHash = $this->generateSecondHalfOfHashFromSecondHalfOfHash($relevantPartOfHash);
        }

        return substr($relevantPartOfHash, 0, 8);
    }

    public function getLastHash(): string
    {
        return $this->hashes[\count($this->hashes) - 1];
    }

    public function generateHash(string $hash): string
    {
        $values = str_split($hash);
        $newHashValues = [];
        foreach ($values as $position => $value) {
            $newHashValues[] = $this->getSingleHashValue($values, $position + 1);
        }

        return implode('', $newHashValues);
    }

    public function generateSecondHalfOfHashFromSecondHalfOfHash(string $hash): string
    {
        $values = str_split($hash);
        for ($position = \count($values) - 1; $position >= 0; $position--) {
            $values[$position] = ($values[$position] + ($values[$position + 1] ?? 0)) % 10;
        }
        return implode('', $values);
    }

    public function getSingleHashValue(array $values, int $patternFactor): string
    {
        $sum = 0;
        foreach ($values as $position => $value) {
            $sum += (int) $value * self::getFactor($patternFactor, $position);
        }

        return substr((string) $sum, -1);
    }

    public function getHashes(): array
    {
        return $this->hashes;
    }

    public function getMultipliedHash(int $multiplier): string
    {
        return str_pad($this->inputHash, strlen($this->inputHash) * $multiplier, $this->inputHash);
    }
}
