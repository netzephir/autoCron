<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 18/05/17
 * Time: 08:26
 */
require __DIR__.'/../autoLoader.php';
$pathCommand = './tools/bench.sh';
$pid = $argv[1];
$executionId = $argv[2];
$file = fopen('tools/test.log','w');
$return = [];
exec($pathCommand.' -csJi '.$pid, $return);
if(isset($return[0]))
{
    $data = json_decode($return[0],true);

}