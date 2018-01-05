<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 10/05/17
 * Time: 09:23
 */

namespace Core\AutoCron;


/**
 * Class DbInfo
 * @package Core\AutoCron
 */
class DbTools
{
    CONST DB_INFO_HOST = '127.0.0.1';
    CONST DB_INFO_USERNAME = 'root';
    CONST DB_INFO_PASSWORD = 'thetime';
    CONST DB_INFO_NAME = 'autoCron';
    CONST TABLE_INFO_JOBS = 'jobs';
    CONST TABLE_INFO_JOB_EXECUTIONS = 'jobExecutions';
    CONST TABLE_INFO_JOB_OPTIONS = 'jobsOptions';
    CONST TABLE_INFO_JOB_STEPS = 'JobSteps';
    CONST TABLE_INFO_JOB_STEP_EXECUTIONS = 'jobStepExecutions';
    CONST TABLE_INFO_JOB_STEP_PARAMETERS = 'jobStepParameters';
    CONST TABLE_INFO_JOB_STEP_PARAMETER_LINKS = 'jobStepParameterLinks';

    public static $pdoInstance;

    /**
     * DbTools constructor.
     */
    private function __construct(){}

    /**
     * @return \PDO
     */
    public static function getPdo() {
        if (self::$pdoInstance === null) {
            self::$pdoInstance = self::buildPdo();
        }
        return self::$pdoInstance;
    }

    /**
     * @return \PDO
     */
    private static function buildPdo()
    {
        $dsn = "mysql:host=".DbTools::DB_INFO_HOST.";dbname=".DbTools::DB_INFO_NAME.";charset=utf8";
        return new \PDO($dsn, DbTools::DB_INFO_USERNAME, DbTools::DB_INFO_PASSWORD,  [\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC]);
    }
}
