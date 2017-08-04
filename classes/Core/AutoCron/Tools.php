<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 10/05/17
 * Time: 09:22
 */

namespace Core\AutoCron;


class Tools
{
    const BENCHMARK_TOOL_PATH = '';
    const CLASS_MAIN_PARAMETER_NAME = 'class';

    // Base code
    const RETURN_CODE_NOT_FINISHED = 0;
    const RETURN_CODE_NOTHING_TO_DO = 1;
    const RETURN_CODE_SUCCESS = 2;

    // Code from -1 to -99 => non blocking error code
    const RETURN_CODE_WARNING = -1;
    const RETURN_CODE_MISSING_PREVIOUS_RESULT = -2;

    // Code from -100 to -199 => blocking error code who will prevent the next execution
    const RETURN_CODE_FATAL_ERROR = -100;
    const RETuRN_CODE_MISSING_PARAMETERS = -101;
    const RETuRN_CODE_MISSING_CLASS_MAIN_PARAMETERS = -102;

    /**
     * @var bool
     */
    public static $verbose = true;


    private function __construct(){}


    /**
     * Show a console message if verbose enabled
     *
     * @param $message
     * @param bool $showHour
     */
    public static function writeMessage($message, $showHour = true)
    {
        if(self::$verbose)
        {
            $toShow = '';
            if($showHour)
            {
                $date = new \DateTime();
                $toShow .= $date->format('Y-m-d H:i:s').' : ';
            }
            $toShow .= $message;
            echo $toShow;
            echo PHP_EOL;
        }
        return true;
    }

    /**
     * Enable or disable autoCron verbose mode
     *
     * @param bool $verbose
     * @return bool
     */
    public static function setVerbose($verbose = true)
    {
        self::$verbose = $verbose;
        return self::$verbose;
    }

    public static function parseArguments ( $args )
    {
        array_shift( $args );
        $endofoptions = false;

        $ret = array
        (
            'options' => array(),
            'flags'    => array(),
            'arguments' => array(),
        );

        while ( $arg = array_shift($args) )
        {

            // if we have reached end of options,
            //we cast all remaining argvs as arguments
            if ($endofoptions)
            {
                $ret['arguments'][] = $arg;
                continue;
            }

            // Is it a command? (prefixed with --)
            if ( substr( $arg, 0, 2 ) === '--' )
            {

                // is it the end of options flag?
                if (!isset ($arg[3]))
                {
                    $endofoptions = true; // end of options;
                    continue;
                }

                $value = "";
                $com   = substr( $arg, 2 );

                // is it the syntax '--option=argument'?
                if (strpos($com,'='))
                {
                    list($com,$value) = explode("=",$com,2);
                }
                // is the option not followed by another option but by arguments
                elseif (isset($args[0]) && strpos($args[0],'-') !== 0)
                {
                    while (isset($args[0]) && strpos($args[0],'-') !== 0)
                    {
                        $value .= array_shift($args).' ';
                    }
                    $value = rtrim($value,' ');
                }
                $ret['options'][$com] = !empty($value) ? $value : true;
                continue;

            }

            // Is it a flag or a serial of flags? (prefixed with -)
            if ( substr( $arg, 0, 1 ) === '-' )
            {
                for ($i = 1; isset($arg[$i]) ; $i++)
                    $ret['flags'][] = $arg[$i];
                continue;
            }

            // finally, it is not option, nor flag, nor argument
            $ret['arguments'][] = $arg;
            continue;
        }

        return $ret;
    }

}