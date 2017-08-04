<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainList extends CI_Controller {

    public function index()
    {
        $this->load->model('Jobs');
        $jobs = $this->Jobs->getJobList();
        d($jobs);
        $this->template->view('mainList.tpl', ['jobs' => $jobs]);
    }
}
