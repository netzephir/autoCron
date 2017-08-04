<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TodoList extends CI_Model 
{
	public function getUserTodoList($complete = false)
	{
		$query = 'SELECT * FROM todoList WHERE idUser = '.$this->client->information['id'];
        $query = $this->db->query($query);
        if($complete)
        {
        	return $this->completeTodoListWithTodo($query->result_array());
        }
        return $query->result_array();
	}

	protected function completeTodoListWithTodo($todoList)
	{
		$this->load->model('Todo');
		foreach($todoList as $key=>$list)
		{
			$todoList[$key]['todo'] = $this->Todo->getTodolistTodo($list['idTodoList']);
		}
		return $todoList;
	}
}