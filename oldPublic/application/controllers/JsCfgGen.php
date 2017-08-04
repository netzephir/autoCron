<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JsCfgGen extends CI_Controller 
{
	public function index()
	{
		header("Content-Type: application/javascript");
		echo 'var cfg = {};';
		echo 'cfg.base_url = "'.$this->config->item('base_url').'";';
		echo 'cfg.absolute_url = "'.$this->config->item('absolute_url').'";';
		return true;
	}
}