<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 28/07/17
 * Time: 16:35
 */

$arguments = \Core\AutoCron\Tools::parseArguments(ARGS);
var_dump($arguments);

if(in_array('h',$arguments['flags']))
{
    echo 'Welcome to Autocron help Manual '.PHP_EOL;
    echo PHP_EOL.PHP_EOL;
    echo 'Available options :'.PHP_EOL;
    echo '-v '.PHP_EOL;
    echo "\t".'Toggle verbose mode (default enabled in dev and disabled in prod)'.PHP_EOL;
    echo '--job=[number]'.PHP_EOL;
    echo "\t".'(int) = uid of the job to execut'.PHP_EOL;
    echo '--step=[number]'.PHP_EOL;
    echo "\t".'(int) = uid of the step to execute (the step need to be in the job )'.PHP_EOL;
    echo PHP_EOL.PHP_EOL;
    echo '--benchmark=[number]'.PHP_EOL;
    echo "\t".'(int) = Set to 0 or 1 it will force the benchmark to off or on'.PHP_EOL;
    echo PHP_EOL.PHP_EOL;
    echo 'For more detail please refer to the MANUAL file in the project root'.PHP_EOL;
    exit(0);
}