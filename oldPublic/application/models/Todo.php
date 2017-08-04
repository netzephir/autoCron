<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo extends CI_Model 
{
	public function getAllUserTodo()
	{
		return $this->get();
	}

	public function getTodolistTodo($idtodoList)
	{
		return $this->get('*', 'WHERE idTodoList = '.(int) $idtodoList.' ORDER BY status');
	}

    public function getUserTodo()
    {
        $query = 'SELECT TD.* FROM todo INNER JOIN todoList TDL ON TDL.idTodoList = TD.idTodoList AND TDL.idUser = '.$this->client->information['id'];
        $query = $this->db->query($query);

        return $query->result_array();
    }

	public function get($select = '*', $where = '')
	{
		$query = $this->db->query('SELECT '.$select.' FROM todo '.$where);

        return $query->result_array();
	}

	public function updateStatus($idtodo, $status)
	{
		return $this->updateTodo($idtodo, array('status', $status));
	}

	public function createTodo($data)
    {
        $query = $this->db->query('INSERT INTO todo VALUES("", '.(int) $data['idTodoList'].', "'.$data['todoDesc'].'", 1) ');

        return $this->db->insert_id();
    }

    public function updateTodo($idTodo, $data)
    {	
    	$query = $this->prepareQueryUpdateSet($data);
    	$query .= ' WHERE idTodo = '.(int) $idTodo;
    	$queryResult = $this->db->query($query);

        return $this->db->affected_rows();
    }

    protected function prepareQueryUpdateSet($data)
    {
    	$query = 'UPDATE todo ';
    	foreach($data AS $key=>$value)
    	{
    		$query .= "SET ".$key." = ".$this->prepareQueryValue($value);
    	}
    	return $query;
    }

    protected function prepareQueryValue($value)
    {
    	if(!is_numeric($value))
    	{
    		$value = '"'.$value.'"';
    	}
    	return $value;
    }
}