<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 15/05/17
 * Time: 08:25
 */

namespace Core\AutoCron;


class JobStepParameters extends AutoCronBaseElement
{
    protected $_parameters = [];
    protected $_table = DbTools::TABLE_INFO_JOB_STEP_PARAMETERS;

    public function __construct($id)
    {
        $this->initById($id);
        return $this;
    }

    /**
     * @param $idStep
     * @param $content
     * @return JobStepParameters
     */
    public static function create($uidStep, $content)
    {
        $uid = Tools::generateUid();
        $query = 'INSERT INTO '.DbTools::TABLE_INFO_JOB_STEP_PARAMETERS.'
                SET uid = :uid,
                    content = :content
        ';
        $pdo = DbTools::getPdo();
        $request = $pdo->prepare($query);
        $request->execute(['uid' => $uid, 'content' => $content]);
        $instance = self::__construct($uid);

        $query2 = 'INSERT INTO '.DbTools::TABLE_INFO_JOB_STEP_PARAMETER_LINKS.' SET uidStep=:uidStep, idParameter = :idParam';
        $request = $pdo->prepare($query2);
        $request->execute(['uidStep'=>$uidStep, 'idParameter' => $instance->getInfo('id')]);
        return $instance;
    }

    public function getParameters()
    {
        if(empty($this->_parameters))
        {
            $this->_parameters = parse_ini_string($this->_data['content']);
        }
        return $this->_parameters;
    }
    public function getParameter($key)
    {
        $parameters = $this->getParameters();
        if(!isset($parameters[$key]))
        {
            return null;
        }
        return $parameters[$key];
    }
}