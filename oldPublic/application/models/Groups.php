<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends CI_Model 
{
	public function getAllGroups()
	{
		$query = $this->db->query('SELECT * FROM userGroups');

        return $query->result_array();
	}

	public function getSimpleListGroups()
	{
		$query = $this->db->query('SELECT id, name FROM userGroups');
		$newList = array();
		$originalList = $query->result_array();
		foreach($originalList as $elem)
		{
			$newList[$elem['id']] = $elem['name'];
		}

        return $newList;
	}

	public function insert($groupName)
	{
		$query = $this->db->query('INSERT INTO userGroups VALUES("", "'.$groupName.'") ');

        return $this->db->insert_id();
	}

	public function delete($idGroup)
	{
		$query = $this->db->query('DELETE FROM userGroups WHERE id = '.(int) $idGroup);

        return $this->db->affected_rows();
	}

	public function update($idGroup, $groupName)
	{
		$query = $this->db->query('UPDATE userGroups SET name = "'.$groupName.'" WHERE id = '.(int) $idGroup);

        return $this->db->affected_rows();
	}
}