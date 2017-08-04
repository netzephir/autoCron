<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CodeTags extends CI_Model 
{
	public function getTagList($partName)
	{
		$query = $this->db->query('SELECT * FROM codeTags WHERE tag like "%'.$partName.'%"');
		$result = $query->result_array();
		$ordered = [];
		foreach($result AS $val)
		{
			$ordered[$val['idCodeTag']] = $val['tag'];
		}
        return $ordered;
	

	public function insertTags($listTags)
	{
		$query = 'INSERT IGNORE INTO codeTags (tag) VALUES ';
		foreach($listTags AS $tag)
		{
			$query .= '("'.$tag.'"),';
		}
		$query = trim($query,',');
		$this->db->query($query);
	}

}