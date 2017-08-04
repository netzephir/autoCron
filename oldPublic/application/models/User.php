<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model 
{

    public function getList()
    {
        $query = $this->db->query('SELECT id, mail, idGroup, username, createDate, lastUpdateDate, lastConnexion, enabled FROM user');

        return $query->result_array();
    }

    public function getUserDetail($idUser)
    {
        if(empty($idUser))
        {
            return false;
        }
        $query = $this->db->query('SELECT id, mail, idGroup, username, createDate, lastUpdateDate, lastConnexion, enabled FROM user WHERE id = '.(int) $idUser);
        $user = $query->result_array();

        if(empty($user))
        {
            return false;
        }
        return $user[0];
    }

    public function getUserSecurity($username)
    {
        if(empty($username))
        {
            return false;
        }
        $query = $this->db->query('SELECT * FROM user WHERE username LIKE "'. $username.'" OR mail LIKE "'. $username.'"');
        $user = $query->result_array();

        if(empty($user))
        {
            return false;
        }
        return $user[0];
    }

    public function save($idUser, $data)
    {
         if($idUser === null)
         {
           return $this->insert($data);
         }
         else
         {
            return $this->update($idUser, $data);
         }
    }

    public function update($idUser, $data)
    {
        $this->db->update('user', $data, array('id' => $idUser));
    }

    public function insert($data)
    {
        $this->db->insert('user', $data);
    }

    public function setPasswordRecoveryToken($login)
    {
        $userToSendMail = $this->User->getUserSecurity($login);
        if($userToSendMail !== false)
        {
            $now = new DateTime();
            $toAdd = new DateIterval('P1D');
            $finalDate = $now->add($toAdd);
            $token = $this->_generatePWRToken($userHash);
            $dataInsert = array('idUser'=>$userToSendMail['id'], 'token'=>$token, 'expiration'=>$finalDate->format('Y-m-d h:i:s'));
            $result = $this->db->insert('passwordRecoveryToken', $dataInsert);
            if($result !== false)
            {
                $userToSendMail['token'] = $token;
                $userToSendMail['tokenExpiration'] = $finalDate;
                return $userToSendMail;
            }
        }
        return false;
    }

    public function updateLastConnexion($idUser)
    {
        $now = new DateTime();
        $this->db->update('user', array('lastConnexion'=>$now->format('Y-m-d h:i:s')), array('id' => $idUser));
    }

    private function _generatePWRToken($userHash)
    {
        $hash = md5(uniqid().$userHash);
        return md5($hash);
    }
}