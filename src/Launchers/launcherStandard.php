<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 16/05/17
 * Time: 08:39
 */
// first require the loader
require_once __DIR__.'/../autoLoader.php';

// Here options for debugging
error_reporting(E_ALL);
ini_set('display_errors',1);

if(!isset($arguments['options']['job']))
{
    throw new Exception('Missing job uid please add --job=(int) options. See more detail in the help section with -h option');
}

// Instanciate job object with the given param
// $arguments is accessible in that file, find more detail in MANUAL file on the project root
$job = new \Core\AutoCron\Job($arguments['options']['job']);
// Instanciate execution object
$execution = new \Core\AutoCron\Execution($job);
// Launch execution
$return = $execution->execute();
var_dump($return);