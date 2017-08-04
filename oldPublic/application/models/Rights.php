<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rights extends CI_Model 
{
    public function insert($rightName)
    {
        $query = $this->db->query('INSERT INTO rights VALUES("", "'.$rightName.'") ');

        return $this->db->insert_id();
    }

    public function createLink($data)
    {
        $query = $this->db->query('INSERT INTO userGroupsRights VALUES("", '.(int) $data['idGroup'].', '.(int) $data['idRight'].', '.(int) $data['access'].') ');

        return $this->db->insert_id();
    }

    public function updateLink($idLink, $newAccess)
    {
        $query = $this->db->query('UPDATE userGroupsRights SET access = '.(int) $newAccess.' WHERE id = '.(int) $idLink);

        return $this->db->affected_rows();
    }

    public function getListRights()
    {
        return $this->_getListRigths();
    }

    public function getUserRights($userGroup)
    {
        $rights = $this->_getListRigths();
        $mapping = $this->_getListMapping();
        foreach($rights AS $keyR=>$right)
        {
            $authorized = false;
            $idMapping = null;
            foreach($mapping AS $entry)
            {
                if($entry['idGroup'] === $userGroup && $entry['idRight'] === $right['id'])
                {
                    $idMapping = $entry['id'];
                    if($entry['access'] == 1)
                    {
                        $authorized = true;
                    }
                }
            }
            $rights[$keyR]['idMapping'] = $idMapping;
            $rights[$keyR]['access'] = $authorized;
        }
        return $rights;
    }

    public function getRightsByGroups()
    {
        $this->load->model('Groups');
        $groups = $this->Groups->getAllGroups();
        $rights = $this->_getListRigths();
        $mapping = $this->_getListMapping();
        $assembly = array();
        $rightKey = 0;
        foreach($rights AS $right)
        {
            $assembly[$rightKey] = $right;
            $assembly[$rightKey]['groups'] = array();
            foreach($groups as $group)
            {
                $authorized = false;
                $idMapping = null;
                foreach($mapping AS $entry)
                {
                    if($entry['idGroup'] === $group['id'] && $entry['idRight'] === $right['id'])
                    {
                        $idMapping = $entry['id'];
                        if($entry['access'] == 1)
                        {
                            $authorized = true;
                        }
                    }
                }
                $assembly[$rightKey]['groups'][] = array(
                        'id' => $group['id'],
                        'name' => $group['name'],
                        'idMapping' => $idMapping,
                        'access' => $authorized
                    );
            }
            $rightKey++;
        }
        return $assembly;
    }

    private function _getListRigths()
    {
        $query = $this->db->query('SELECT * FROM rights');

        return $query->result_array();
    }

    private function _getListMapping()
    {
        $query = $this->db->query('SELECT * FROM userGroupsRights');

        return $query->result_array();
    }

}