<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 12/05/17
 * Time: 08:24
 */

namespace Core\AutoCron;


class JobStep extends AutoCronBaseElement
{
    /**
     * @var array
     */
    protected $_parameters = [];

    protected $_table = DbTools::TABLE_INFO_JOB_STEPS;
    /**
     * JobStep constructor.
     */
    public function __construct($uid)
    {
        $this->initByUid($uid);
        return $this;
    }

    /**
     * @param $idJob
     * @param $name
     * @param int $position
     * @return JobStep
     */
    public static function create($idJob, $name, $class, $namespace = "\\", $position = 0)
    {
        $uid = Tools::generateUid();
        $query = 'INSERT INTO '.DbTools::TABLE_INFO_JOB_STEPS.'
                SET uid = :uid,
                    idJob = :idJob,
                    position = :position,
                    class = :class,
                    namespace = :namespace,
                    stepName = :stepName
        ';
        $pdo = DbTools::getPdo();
        $request = $pdo->prepare($query);
        $request->execute(['uid' => $uid, 'idJob'=>$idJob, 'position' => $position, 'stepName' => $name, 'class' => $class, 'namespace' => $namespace]);

        return self::__construct($uid);
    }

    /**
     * @return JobStepParameters[]
     */
    public function getParameters()
    {
        if(empty($this->_parameters))
        {
            $query = 'SELECT idParameter FROM '.DbTools::TABLE_INFO_JOB_STEP_PARAMETER_LINKS.' WHERE idStep = :idStep';
            $pdo = DbTools::getPdo();
            $request = $pdo->prepare($query);
            $request->execute(['idStep'=>$this->getInfo('id')]);
            while(($row = $request->fetch()) !== false)
            {
                $this->_parameters[] = new JobStepParameters($row['idParameter']);
            }
        }
        return $this->_parameters;
    }

    public function getParameter($key)
    {
        $parameters =  $this->getParameters();
        $result = null;
        foreach($parameters AS $parameter)
        {
            if(($tmpResult = $parameter->getParameter($key)) !== null)
            {
                $result = $tmpResult;
                break;
            }
        }
        return $result;
    }

    /**
     * @param JobStepParameters $parameter
     */
    public function addParameters(JobStepParameters $parameter)
    {
        $this->_parameters[] = $parameter;
    }
}