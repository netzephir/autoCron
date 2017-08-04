<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TemplateSample extends CI_Controller {

	public function index()
	{

        $this->template->setVar('maCle', 'mavaleur');

        $this->template->addJs('templateSample.js');
        $this->template->addCss('templateSample.css');

        $this->template->setTitle('template Sample');

        //le deuxieme paramètre permet de passer aussi des datas (celle-ci ne sont pas durable)
        //le troisième paramètre permet de récupérer la vue au lieu de l'afficher
        $this->template->view('TemplateSample/index.tpl', array('data2'=>'ici des datas aussi'), true);
	}
	public function ajaxAction()
	{
		$this->template->setDefaultTemplate('empty.tpl');

		$this->template->clearJs();
		$this->template->clearCss();
		$this->template->clearVar();

		$this->template->view('TemplateSample/index.tpl', array('data2'=>'ici des datas aussi'), true);
	}
	
}
