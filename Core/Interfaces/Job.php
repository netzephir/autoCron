<?php
namespace Core\Interfaces;
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 25/08/17
 * Time: 08:40
 */
interface Job
{
    public function run();
    public function checkParameters();
}