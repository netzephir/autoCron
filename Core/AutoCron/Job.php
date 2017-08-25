<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 10/05/17
 * Time: 19:41
 */

namespace Core\AutoCron;


class Job extends AutoCronBaseElement
{
    /**
     * @var array
     */
    protected $_steps = [];

    protected $_table = DbTools::TABLE_INFO_JOBS;
    /**
     * Job constructor.
     *
     * @return Job
     */
    public function __construct($uid)
    {
        $this->initByUid($uid);
        return $this;
    }

    /**
     * Create a new job
     *
     * @param $name
     * @param int $maxParallelExecution
     * @return Job
     */
    public static function create($name, $maxParallelExecution = 0)
    {
        $uid = Tools::generateUid();
        $query = 'INSERT INTO '.DbTools::TABLE_INFO_JOBS.'
                SET uid = :uid,
                    jobName = :jobName,
                    maxParallelExecution = :maxParallelExecution
        ';
        $pdo = DbTools::getPdo();
        $request = $pdo->prepare($query);
        $request->execute(['uid' => $uid, 'maxParallelExecution'=>$maxParallelExecution, 'jobName' => $name]);

        return self::__construct($uid);
    }

    /**
     * return a list of job's steps
     *
     * @return JobStep[]
     */
    public function getSteps()
    {
        if(empty($this->_steps))
        {
            $query = 'SELECT uid FROM '.DbTools::TABLE_INFO_JOB_STEPS.' WHERE uidJob = :uidJob';
            $pdo = DbTools::getPdo();
            $request = $pdo->prepare($query);
            $result = $request->execute(['uidJob' => $this->getInfo('uid')]);
            while(($row = $request->fetch()) !== false)
            {
                $this->_steps[] = new JobStep($row['uid']);
            }
        }
        return $this->_steps;
    }

    /**
     * Export job and everything attached to a json string
     *
     * todo rebuild
     * @return string
     */
    public function export()
    {
        $data = $this->_data;
        unset($data['id']);
        unset($data['updateAt']);
        $steps = $this->getSteps();
        $data['steps'] =  [];
        foreach($steps AS $step)
        {
            $dataStep = $step->getAllInfo();
            unset($dataStep['updateAt']);
            unset($dataStep['id']);

            $parameters = $step->getParameters();
            $dataStep['parameters'] = [];
            foreach($parameters AS $parameter)
            {
                $dataParameter = $parameter->getAllInfo();
                unset($dataParameter['id']);
                unset($dataParameter['updateAt']);
                $dataStep['parameters'][] = $dataParameter;
            }

            $data['steps'][] = $dataStep;
        }
        return json_encode($data);
    }

    /**
     * Import a json string and create a new program
     *
     * todo rebuild
     * @param $json
     * @return Job
     */
    public static function import($json)
    {
        $data = json_decode($json, true);
        $newJob = self::create($data['name'],$data['maxParallelExecution']);
        foreach($data['steps'] as $step)
        {
            $newStep = JobStep::create($newJob->getInfo('id'), $step['name'], $step['position']);
            foreach($step['parameters'] AS $parameter)
            {
                $newParameter = JobStepParameters::create($newStep->getInfo('id'),$parameter['content']);
                $newStep->addParameters($newParameter);
            }
            $newJob->addStep($newStep);
        }
        return $newJob;
    }

    /**
     * @param JobStep $step
     * @return JobStep[]
     */
    public function addStep(JobStep $step)
    {
        $this->_steps[] = $step;
        return $this->_steps;
    }
}