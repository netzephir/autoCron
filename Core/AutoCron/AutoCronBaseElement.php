<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 15/05/17
 * Time: 08:31
 */

namespace Core\AutoCron;


abstract class AutoCronBaseElement
{
    protected $_data;
    protected $_table;
    /**
     * @param int $uid
     * @return $this
     */
    protected function initByUid($uid)
    {
        $query = 'SELECT * FROM '.$this->_table.' WHERE uid = :uid';
        $pdo = DbTools::getPdo();
        $request = $pdo->prepare($query);
        $request->execute(['uid' => $uid]);
        $this->_data = $request->fetch();
        return $this;
    }

    /**
     * @param int $id
     * @return $this
     */
    protected function initById($id)
    {
        $query = 'SELECT * FROM '.$this->_table.' WHERE id = :id';
        $pdo = DbTools::getPdo();
        $request = $pdo->prepare($query);
        $request->execute(['id' => $id]);
        $this->_data = $request->fetch();
        return $this;
    }

    /**
     * @param $key
     * @return null
     */
    public function getInfo($key)
    {
        if(!isset($this->_data[$key]))
        {
            return null;
        }
        return $this->_data[$key];
    }

    /**
     * @return mixed
     */
    public function getAllInfo()
    {
        return $this->_data;
    }

    /**
     * @param $key
     * @param $value
     * @return null
     */
    public function updateInfo($key, $value)
    {
        if(!isset($this->_data[$key]))
        {
            return null;
        }
        $this->_data[$key] = $value;
        $this->save();
        return $this->getInfo($key);
    }

    /**
     * @return bool
     */
    protected function save()
    {
        if(empty($this->_data))
        {
            return false;
        }
        $query = 'UPDATE `'.$this->_table.'` SET ';
        $nbThingToRegister = 0;
        $params = [];
        foreach($this->_data AS $column=>$value)
        {
            if($column != 'uid' && $column != 'updateAt')
            {
                if($nbThingToRegister > 0)
                {
                    $query .= ', ';
                }
                $query .= '`'.$column.'`= :'.$column;
                $params[$column] = $value;
                $nbThingToRegister++;
            }
        }
        $query .= ' WHERE uid='.$this->getInfo("uid");
        if($nbThingToRegister === 0)
        {
            return false;
        }
        $pdo = DbTools::getPdo();
        $request = $pdo->prepare($query);
        $result = $request->execute($params);
        return (bool) $result;
    }
}