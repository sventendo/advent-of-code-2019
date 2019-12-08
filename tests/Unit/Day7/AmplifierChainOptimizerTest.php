<?php
namespace Sventendo\AdventOfCode2019\Tests\Unit\Day7;

use Illuminate\Container\Container;
use PHPUnit\Framework\TestCase;
use Sventendo\AdventOfCode2019\Day7\AmplifierChainOptimizer;

class AmplifierChainOptimizerTest extends TestCase
{
    public function testHighestValue()
    {
        $container = new Container();
        /** @var AmplifierChainOptimizer $subject */
        $subject = $container->make(AmplifierChainOptimizer::class);
        $software = explode(',', '3,15,3,16,1002,16,10,16,1,16,15,15,4,15,99,0,0');
        $this->assertEquals(43210, $subject->getHighestOutput($software, range(0, 4), false));

        /** @var AmplifierChainOptimizer $subject */
        $subject = $container->make(AmplifierChainOptimizer::class);
        $software = explode(',', '3,26,1001,26,-4,26,3,27,1002,27,2,27,1,27,26,27,4,27,1001,28,-1,28,1005,28,6,99,0,0,5');
        $this->assertEquals(139629729, $subject->getHighestOutput($software, range(5, 9), true));
    }
}
