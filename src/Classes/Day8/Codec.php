<?php
namespace Sventendo\AdventOfCode2019\Day8;

class Codec
{
    public function getChecksum(string $data, int $width, int $height)
    {
        $layerSize = $width * $height;

        $layers = str_split(trim($data), $layerSize);

        $layerWithFewestZeros = null;
        $fewestZeros = null;

        foreach ($layers as $index => $layer) {
            $zeros = $this->countInLayer($layer, '0');
            if ($layerWithFewestZeros === null) {
                $layerWithFewestZeros = $index;
                $fewestZeros = $zeros;
            }

            if ($zeros < $fewestZeros) {
                $fewestZeros = $zeros;
                $layerWithFewestZeros = $index;
            }
        }

        $targetLayer = $layers[$layerWithFewestZeros];

        return $this->countInLayer($targetLayer, '1') * $this->countInLayer($targetLayer, '2');
    }

    public function countInLayer($layer, $value)
    {
        return substr_count($layer, $value);
    }

    public function decode(string $data, int $width, int $height)
    {
        $layerSize = $width * $height;
        $image = array_fill(0, $layerSize, '2');

        $layers = str_split(trim($data), $layerSize);

        for ($i = 0; $i < $layerSize; $i++) {
            foreach ($layers as $layer) {
                if ($layer[$i] !== '2' && $image[$i] === '2') {
                    $image[$i] = $layer[$i];
                }
            }
        }

        return chunk_split(implode('', $image), $width);
    }
}
