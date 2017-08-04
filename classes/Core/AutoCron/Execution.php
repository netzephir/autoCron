<?php

/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 10/05/17
 * Time: 08:27
 */
namespace Core\AutoCron;

class Execution
{
    use Traits\ExecutionLog;
    /**
     * @var Job
     */
    protected $_job;
    /**
     * @var int
     */
    protected $_executionId;
    /**
     * @var JobStep[]
     */
    protected $_steps = [];
    /**
     * @var array
     */
    private $_stepMessages = [];
    /**
     * @var int
     */
    private $_stepInProgress = 0;
    /**
     * @var bool
     */
    protected $_verbose = true;

    /**
     * @var null|int
     */
    protected $_forceBenMark = null;

    /**
     * Execution constructor.
     * @param Job $program
     */
    public function __construct(Job $program)
    {
        $this->_job = $program;
        $this->_steps = $this->_job->getSteps();
        $this->initCliOptions(Tools::parseArguments(ARGS));
        Tools::setVerbose($this->getVerbose());
    }

    /**
     * Main execution function where everything happen ( except what you except, just because )
     *
     * @return int
     */
    public function execute()
    {
        $this->logExecutionStart();
        // enable si (bench  = 1 OR param exist && =1 ) AND param doesn't exist or = 1
        if(($this->getJob()->getInfo('benchmark') == 1 || ($this->getForceBenchMark() !== null && $this->getForceBenchMark() == 1)) && ($this->getForceBenchMark() === null || $this->getForceBenchMark() == 1))
        {
            $this->startBenchMark();
        }

        while(isset($this->_steps[$this->_stepInProgress]))
        {
            $this->logStepStart($this->_steps[$this->_stepInProgress]->getInfo('uid'));
            //todo check parralel eecution , if blocked launch check if PID run
            if(($returnCode = $this->execStepNb($this->_stepInProgress)) != Tools::RETURN_CODE_SUCCESS)
            {
                $this->logExecutionEnd(Tools::RETURN_CODE_SUCCESS);
                $this->logStepEnd($this->_steps[$this->_stepInProgress]->getInfo('uid'), $returnCode, json_encode($this->_stepMessages));
                return $returnCode;
            }
            $this->logStepEnd($this->_steps[$this->_stepInProgress]->getInfo('uid'), $returnCode, json_encode($this->_stepMessages));
            $this->_stepMessages = [];
            $this->_stepInProgress++;
        }
        $this->logExecutionEnd(Tools::RETURN_CODE_SUCCESS);
        return Tools::RETURN_CODE_SUCCESS;
    }

    /**
     * @param $nb
     * @return mixed
     */
    protected function execStepNb($nb)
    {
        $className = $this->_steps[$nb]->getInfo('namespace').$this->_steps[$nb]->getInfo('class');
        $instance = new $className($this->_steps[$nb]->getParameters(),$this);
        if(($returnCode = $instance->checkParameters()) < Tools::RETURN_CODE_SUCCESS)
        {
            return $returnCode;
        }
        return $instance->run();
    }

    /*
     * @TODO to finish
     */
    protected function startBenchMark()
    {
        $pid = getmypid();
        exec('php tools/benchExecuter.php '.$pid.' '.$this->_executionId.' &');
    }

    /**
     * @param $message
     * @param string|null $key
     * @return true
     */
    public function addResult($message,$key = null)
    {
        if(!is_null($key))
        {
            $this->_stepMessages[$key] = $message;
        }
        else
        {
            $this->_stepMessages[] = $message;
        }
        return true;
    }

    /**
     * @param array $options
     */
    protected function initCliOptions(array $options)
    {
        if(in_array('v',$options['flags']))
        {
            if($this->getVerbose() === true)
            {
                $this->setVerbose(false);
            }
            else
            {
                $this->setVerbose(true);
            }
        }
        if(isset($options['options']['benchmark']))
        {
            $this->setForceBenchMark((int) $options['options']['benchmark']);
        }
    }

    /**
     * @return bool
     */
    public function getVerbose()
    {
        return $this->_verbose;
    }

    /**
     * @param bool $verbose
     * @return bool
     */
    public function setVerbose(bool $verbose)
    {
        $this->_verbose = $verbose;
        return $this->getVerbose();
    }

    /**
     * @return int
     */
    public function getExecutionId()
    {
        return $this->_executionId;
    }

    /**
     * @param $executionId
     * @return int
     */
    public function setExecutionId($executionId)
    {
        $this->_executionId = $executionId;
        return $this->getExecutionId();
    }

    /**
     * @return Job
     */
    public function getJob()
    {
        return $this->_job;
    }

    /**
     * @param Job $job
     * @return Job
     */
    public function setJob(Job $job)
    {
        $this->_job = $job;
        return $this->getJob();
    }

    /**
     * @return JobStep[]
     */
    public function getSteps()
    {
        return $this->_steps;
    }

    /**
     * @param JobStep $step
     * @return JobStep[]
     */
    public function addSteps(JobStep $step)
    {
        $this->_steps[] = $step;
        return $this->getSteps();
    }

    /**
     * @param JobStep[] $steps
     * @return JobStep[]
     */
    public function setSteps(array $steps)
    {
        $this->_steps = $steps;
        return $this->getSteps();
    }

    /**
     * @return null|int
     */
    public function getForceBenchMark()
    {
        return $this->_forceBenMark;
    }

    /**
     * @param int $forceBenchMark
     * @return null|int
     */
    public function setForceBenchMark(int $forceBenchMark)
    {
        $this->_forceBenMark = $forceBenchMark;
        return $this->getForceBenchMark();
    }
}
