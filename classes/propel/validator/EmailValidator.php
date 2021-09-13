<?php
require_once 'propel/validator/BasicValidator.php';

/**
 * A simple validator for email fields.
 * 
 * @package propel.validator
 */
class EmailValidator implements BasicValidator
{

	public function isValid (ValidatorMap $map, $str, PropelPDO $con=null) 
	{
		return preg_match('/^[a-zA-Z0-9][\w\.\-_]*[a-zA-Z0-9]@[a-zA-Z0-9][\w\.\-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/', $str) !== 0;
	}
}
?>