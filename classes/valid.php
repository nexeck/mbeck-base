<?php defined('SYSPATH') or die('No direct script access.');

class Valid extends Kohana_Valid {

	/**
	 * Checks if a phone number is valid.
	 *
	 * @param	 string	 phone number to check
	 * @return	boolean
	 */
	public static function phone($number, $length = 5)
	{

		// Remove all non-digit characters from the number
		$number = preg_replace('/\D+/', '', $number);

		// Check if the number is within range
		return (strlen($number) >= $length);
	}

	/**
	 * German Date
	 *
	 * Tests if a string is a valid date string.
	 *
	 * @param	 string	 date to check
	 * @return	boolean
	 */
	public static function date($str)
	{
		$date_expression = '/^(0[1-9]|[12][0-9]|3[01]|[1-9])\.(0[1-9]|1[012]|[1-9])\.(\d{4}|\d{2})$/';
		if (preg_match($date_expression, (string) $str) === false)
		{
			return false;
		}

		list($day, $month, $year) = preg_split("/[\s\.]+/", $str);

		return (checkdate($month, $day, $year) !== false);
	}

	/**
	 * Checks that at least $needed of $fields are not_empty
	 *
	 * @param	 array		array of values
	 * @param	 integer	Number of fields required
	 * @param	 array		Field names to check.
	 * @return	boolean
	 */
	public static function at_least($validation, $needed = 1, $fields)
	{
		$found = 0;

		foreach ($fields as $field)
		{
			if (isset($validation[$field]) AND Valid::not_empty($validation[$field]))
			{
				$found++;
			}
		}

		if ($found >= $needed)
			return TRUE;

		$validation->error($fields[0], 'at_least', array($needed, $fields));
	}

	/**
	 * Größer Als Methode
	 *
	 * @static
	 * @param $validation
	 * @param $field1
	 * @param $field2
	 * @param $field2_name string  Wird für den Fehlertext benutzt, und sollte die Bezeichnung des Feld1 beinhalten
	 * @return bool
	 */
	public static function date_greater_than($validation, $field1, $field2, $field2_name)
	{
		$date1 = new DateTime($validation[$field1]);
		$date2 = new DateTime($validation[$field2]);

		return ($date1 > $date2);
	}


	/**
	 * Kleiner Als Methode
	 *
	 * @static
	 * @param $validation
	 * @param $field1
	 * @param $field2
	 * @param $field2_name string  Wird für den Fehlertext benutzt, und sollte die Bezeichnung des Feld1 beinhalten
	 * @return bool
	 */
	public static function date_less_than($validation, $field1, $field2, $field2_name)
	{
		$date1 = new DateTime($validation[$field1]);
		$date2 = new DateTime($validation[$field2]);

		return ($date1 < $date2);
	}

} // Valid
