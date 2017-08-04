<?php

/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 16/05/17
 * Time: 08:43
 */
class TestCron extends \Core\AutoCron\AutoCron
{
    public function checkParameters()
    {
        return parent::checkParameters();
    }

    public function run()
    {
        \Core\AutoCron\Tools::writeMessage('Do things');
        return \Core\AutoCron\Tools::RETURN_CODE_SUCCESS;
    }
}