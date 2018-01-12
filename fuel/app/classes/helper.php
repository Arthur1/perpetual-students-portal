<?php
class Helper
{
	public static function isset($val, $default)
	{
		return isset($val) ? $val : $default;
	}
}