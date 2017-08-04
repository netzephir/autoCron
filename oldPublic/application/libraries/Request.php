<?php

Class Request 
{
	public function get($varName)
	{
		if(isset($_GET[$varName]))
		{
			return $this->secureRequestVar($_GET[$varName]);
		}
		return null;
	}

	public function post($varName)
	{
		if(isset($_POST[$varName]))
		{
			return $this->secureRequestVar($_POST[$varName]);
		}
		return null;
	}

	public function extractRequestData($opt = "all")
	{
		$toExtract = $_REQUEST;
		if($opt === 'GET')
		{
			$toExtract = $_GET;
		}
		if($opt === 'POST')
		{
			$toExtract = $_POST;
		}
		$data = [];
		foreach($toExtract AS $key=>$value)
		{
			$data[$key] = $this->secureRequestVar($value);
		}
		return $data;
	}

	public function secureRequestVar($var)
	{
		return xss_clean($var);
	}
}