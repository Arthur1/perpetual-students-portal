<?php
class Rule
{
	public static function _validation_not_duplicate(array $val)
	{
		$val = array_diff($val, ['']);
		$val = array_values($val);
		return count($val) === count(array_unique($val));
	}
}