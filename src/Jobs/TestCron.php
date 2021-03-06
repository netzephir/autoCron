<?php
namespace Jobs;

class TestCron extends \Core\AutoCron\AutoCron implements \Core\Interfaces\Job
{
    public function checkParameters()
    {
        return parent::checkParameters();
    }

    public function run()
    {
        \Core\AutoCron\Tools::writeMessage('do things');
        $this->_executionRef->addResult('coucou db','dbmessage');
        $this->_executionRef->addResult('hello world');
        sleep(3);
        return \Core\AutoCron\Tools::RETURN_CODE_SUCCESS;
    }
}