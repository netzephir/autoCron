<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 16/05/17
 * Time: 08:15
 */

namespace Core\AutoCron;


class AutoCron
{
    protected $_params = [];
    protected $_executionRef;
    final public function __construct($params, Execution &$execution)
    {
        $this->_params = $params;
        $this->_executionRef = $execution;
    }

    public function checkParameters()
    {
        return Tools::RETURN_CODE_SUCCESS;
    }

    public function run(){}
}