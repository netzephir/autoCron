<?php

class Believe_MemoryManager
{
	protected $memoryAllowed = 0;
	protected $defaultMemory = 0;
	protected $defaultMemorySet = false;

	public static function setMemory($value)
	{
		self::getMemory();
		self::$memoryAllowed = self::convertIniMemory($value);
		ini_set('memory_limit', self::convertToMo(self::$memoryAllowed).'M');
		return self::$memoryAllowed;
	}

	public static function addMemory($value)
	{
		$newValue = self::getMemory() + self::convertIniMemory($value);
		return self::setMemory($newValue);
	}

	public static function subMemory($value)
	{
		$newValue = self::getMemory() - self::convertIniMemory($value);
		return self::setMemory($newValue);
	}

	public static function resetMemory()
	{
		self::getMemory();
		return self::setMemory(self::$defaultMemory);
	}

	public static function setDefaultMemory($value)
	{
		self::$defaultMemory = self::convertIniMemory($value);
		self::$defaultMemorySet = true;
		return self::$defaultMemory;
	}

	public static function getMemory()
	{
		if(self::$defaultMemorySet)
		{
			if(!self::checkMemoryValueUpToDate())
			{
				self::$memoryAllowed = self::convertIniMemory(self::getIniMemory());
			}
		}
		else
		{
			self::$memoryAllowed = self::setDefaultMemory(self::convertIniMemory(self::getIniMemory()));
		}
		return self::$memoryAllowed;
	}

	protected static function checkMemoryValueUpToDate()
	{
		if(self::convertIniMemory() == self::$memoryAllowed)
		{
			return true;
		}
		return false;
	}

	protected static function convertToMo($value)
	{
		return $value * 1024 * 1024;
	}

	protected static function getIniMemory()
	{
		return ini_get('memory_limit');
	}

	protected static function convertIniMemory($string)
	{
		sscanf ($string, '%u%c', $number, $suffix);
	    if (isset ($suffix))
	    {
	    	// apply "une puissance de 1024" X to memory value from suffix pos in the string "KMG" 
	        $number = $number * pow(1024,strpos(' KMG', strtoupper($suffix)));
	    }
	    return $number;
	}
}