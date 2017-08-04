<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 22/05/17
 * Time: 09:05
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class JobEdit extends CI_Controller {

    public function index($id)
    {
        $this->load->model('Jobs');
        $job = $this->Jobs->getFromId((int) $id);
        d($job);
        $this->template->view('jobEdit.tpl', ['job' => $job]);
    }
}
