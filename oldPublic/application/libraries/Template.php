<?php
if ( ! defined('BASEPATH') )
	exit( 'No direct script access allowed' );

class Template 
{
	private $_template = 'default.tpl';
	private $_templateDir = 'template';
	private $ci;
	private $_var = array();
	private $_js = array();
	private $_css = array();
	private $_title = 'No title';

	public function __construct()
	{
		$this->ci = & get_instance();
		$this->ci->load->library('smartyci');
	}

	public function view($page, $data = array(), $render = true)
	{
		//$this->ci->smartyci->assign($name,$value);
		if(!$this->checkIfPageExist($page))
		{
			return false;
		}
		$this->ci->smartyci->assign('title',$this->_title);
		$this->ci->smartyci->assign('jsList',$this->_js);
		$this->ci->smartyci->assign('cssList',$this->_css);
		foreach($this->_var AS $key=>$var)
		{
			$this->ci->smartyci->assign($key,$var);
		}
		foreach($data AS $keyD=>$varD)
		{
			$this->ci->smartyci->assign($keyD,$varD);
		}
		$content = $this->ci->smartyci->fetch($page);
		$this->ci->smartyci->assign('content',$content);

		
		if($render)
		{
			return $this->ci->smartyci->display($this->_templateDir.'/'.$this->_template);
		}
		else
		{
			return $this->ci->smartyci->fetch($this->_templateDir.'/'.$this->_template);
		}
	}

	public function setDefaultTemplate($template)
	{
		if(!$this->checkIfPageExist($this->_templateDir.'/'.$template))
		{
			return false;
		}
		$this->_template = $template;
		return true;
	}

	public function checkIfPageExist($page)
	{
		return $this->ci->smartyci->templateExists($page);
	}

	public function setVar($name,$value)
	{
		$this->_var[$name] = $value;
	}

	public function getVar($varName = null)
	{
		if($varName === null)
		{
			return $this->_var;
		}
		else
		{
			if(isset($this->_var[$varName]))
			{
				return $this->_var[$varName];
			}
		}
		return false;
	}
	public function setTitle($title)
	{
		$this->_title = $title;
	}
	public function addJs($file)
	{
		$this->_js[] = $file;
	}
	public function addCss($file)
	{
		$this->_css[] = $file;
	}
	public function clearJs(){$this->_js = array();}
	public function clearCss(){$this->_css = array();}
	public function clearVar(){$this->_var = array();}
	public function getTitle(){return $this->_title;}
	public function render($page){return $this->view($page,false);}
}