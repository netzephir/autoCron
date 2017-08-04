<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Model
{
	public function getXLines($nbLInes)
	{
        $query = $this->db->get('jobs', $nbLInes);
        return $query->result();
	}

	public function getJobList($nb = 100, $offset = 0)
    {
        $query = $this->db->query('
          SELECT J.*, 
          (SELECT JE.endDate FROM jobExecutions JE WHERE JE.idJob = J.id ORDER BY JE.id DESC LIMIT 0, 1) AS lastEndExecution, 
          (SELECT JE.status FROM jobExecutions JE WHERE JE.idJob = J.id ORDER BY JE.id DESC LIMIT 0, 1) AS lastStatus, 
          JO.benchmark 
          FROM jobs J
          LEFT JOIN jobsOptions JO ON JO.idJob = J.id
          LIMIT '.(int) $offset.', '.(int) $nb .'
        ');
        return $query->result_array();
    }
}