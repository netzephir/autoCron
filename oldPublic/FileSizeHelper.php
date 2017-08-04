<?php
class Believe_GdMemoryUsageHelper
{
	protected $baseCalculMemory = 1;

	public static function getNeededMemoryForImageCreate($width, $height, $truecolor = true) 
	{
	    return $width*$height*(2.2+($truecolor*3));
	}
}