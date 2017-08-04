<?php
define("CORE_PATH",".");
define('ARGS',$argv);
spl_autoload_register(function($className)
{
    $namespace=str_replace("\\","/",__NAMESPACE__);
    $className=str_replace("\\","/",$className);
    $class=CORE_PATH."/classes/".(empty($namespace)?"":$namespace."/")."{$className}.php";
    include_once($class);
});

require_once __DIR__.'/init.php';