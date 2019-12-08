<?php
namespace Sventendo\AdventOfCode2019\Day7;

class AmplifierChain
{
    protected $software;
    /** @var IntcodeComputer[] */
    private $amplifiers;

    public function __construct(array $software)
    {
        $this->software = $software;
    }

    public function run(array $phaseSettings)
    {
        $input = 0;

        foreach ($phaseSettings as $index => $phaseSetting) {
            $amplifier = new IntcodeComputer($this->software, [ $phaseSetting, $input ]);
            $input = $amplifier->run()->getValue();
        }

        return $input;
    }

    public function runFeedbackLoop(array $phaseSettings)
    {
        $this->setupAmplifiers($phaseSettings);

        $amplifierPointer = 0;

        for ($cycle = 0; $cycle < 1000; $cycle++) {
            $response = $this->amplifiers[$amplifierPointer]->run(true);
            if ($response->getStatusCode() === 99 && $amplifierPointer === \count($phaseSettings) - 1) {
                return $response->getValue();
            }

            $amplifierPointer = ($amplifierPointer + 1) % \count($phaseSettings);
            $this->amplifiers[$amplifierPointer]->addInput($response->getValue());
        }

        throw new \Exception('More than 1000 cycles ran. Aborting.');
    }

    /**
     * @param array $phaseSettings
     */
    protected function setupAmplifiers(array $phaseSettings): void
    {
        foreach ($phaseSettings as $phaseSetting) {
            $this->amplifiers[] = new IntcodeComputer($this->software, [ $phaseSetting ]);
        }

        $this->amplifiers[0]->addInput('0');
    }
}
