<?php

use Netzephir\AutoCron\AutoCron;
use PHPUnit\Framework\TestCase;

class AutoCronTest extends TestCase {

    public function testNachHasCheese()
    {
        $autoCron = new AutoCron;
        $this->assertTrue($autoCron->baseFunction());
        $this->assertFalse($autoCron->baseFunction(false));
    }

}