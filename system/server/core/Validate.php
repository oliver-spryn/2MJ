<?php
/**
 * Epoch Cloud Management Platform
 * 
 * LICENSE
 * 
 * By viewing, using, or actively developing this application in any way, you are
 * henceforth bound the license agreement, and all of its changes, set forth by
 * ForwardFour Innovations. The license can be found, in its entirety, at this 
 * address: http://forwardfour.com/license.
 * 
 * @copyright  Copyright (c) 2011 and Onwards, ForwardFour Innovations
 * @license    http://forwardfour.com/license    [Proprietary/Closed Source]  
 */
 
/**
 * Validate is simply a container class for a series of methods which will perform
 * various types of validation
 *
 * @category Core
 * @package core
 * @since v0.1 Dev
 */

class Validate {
/**
 * A simple string containing the HTML and JavaScript to redirect the user back to 
 * the form in the event of validation failure
 *
 * @access     private
 * @static
 * @var        boolean
 */
	private static $redirect = " Click <a href=\"javascript:window.location = document.location.href\">here</a> to retry.";
	
/**
 * The most simple form of validation, which ensures a value has been provided. This
 * method is also able to perform other tests on a string, as described in each of 
 * the @param annotations below.
 *
 * @param      string      $string     The string to validate
 * @param      string      $matches    A value that $string should match
 * @param      int         $sizeSmall  The smallest amount of characters the given string should contain
 * @param      int         $sizeLarge  The largest amount of characters the given string should contain
 * @param      int         $sizeEquals The number of characters the given string should equal
 * @param      boolean     $optional   Whether or not $string is required. This is useful you only wish to use the above testing conditions on $string.
 * @access     public
 * @return     void
 * @since      v0.1 Dev
 */
	public static function required($string, $matches = false, $sizeSmall = false, $sizeLarge = false, $sizeEquals = false, $optional = false) {
		try {
		//See if the string is empty
			!$optional && empty($string) && !is_numeric($string) ? $error = "A required value was empty." : true;
			
			if ($optional && empty($string)) {
				return $string;
			}
			
		//Does it match the "$match" string?
			if ($matches && is_string($matches)) {
				$string !== $matches ? $error = "The given value must be equal to: <strong>" . $matches . "</strong>." : true;
			}
			
		//Does it match the "$match" array?
			if ($matches && is_array($matches)) {
				$equalTo = "";
				
				for ($i = 0; $i <= sizeof($matches) - 1; $i++) {
				//Add a friendly "or" to the next-to-last list of suggestions
					$i == sizeof($matches) - 2 ? $equalTo .= $matches[$i] . ", or " : $equalTo .= $matches[$i] . ", ";
				}
				
				!in_array($string, $matches) ? $error = "The given value must be equal to: <strong>" . rtrim($equalTo, ", ") . "</strong>." : true;
			}
			
		//Is it big enough?
			if (is_numeric($sizeSmall) && !is_numeric($sizeLarge) && strlen($string) < $sizeSmall) {
				$error = "A required value was too short. At least <strong>" . $sizeSmall . "</strong> chatacter(s) are required.";
		//Is it small enough?
			} elseif (is_numeric($sizeLarge) && !is_numeric($sizeSmall) && strlen($string) > $sizeLarge) {
				$error = "A required value was too long. Only <strong>" . $sizeLarge . "</strong> chatacter(s) are allowed.";
		//Is it between a given range?
			} elseif (is_numeric($sizeSmall) && is_numeric($sizeLarge) && $sizeSmall < $sizeLarge && (strlen($string) < $sizeSmall || strlen($string) > $sizeLarge)) {
				$error = "A required value was not within the specified range. Between <strong>" . $sizeSmall . "</strong> and <strong>" . $sizeLarge . "</strong> chatacter(s) are required.";
		//Is is equal to a given length?
			} elseif (is_numeric($sizeEquals) && strlen($string) !== $sizeEquals) {
				$error = "A required value was not within the specified range. <strong>" . $sizeEquals . "</strong> chatacter(s) are required.";
			}
			
			if (isset($error)) {
				throw new Exception($error);
			} else {
				return $string;
			}
		} catch (Exception $e) {
			die($e->getMessage() . self::$redirect);
		}
	}
	
/**
 * Check to see if the supplied value is numeric. This method is also able to
 * perform other tests on a number, as described in each of the @param
 * annotations below.
 *
 * @param      int         $number    The input to validate
 * @param      int         $small     The smallest value the number may equal
 * @param      int         $large     The largest value the number may equal
 * @param      int         $equalTo   The only value the number may equal
 * @param      boolean     $optional  Whether or not $number is required. This is useful you only wish to use the above testing conditions on $number.
 * @access     public
 * @return     void
 * @since      v0.1 Dev
 */
	public static function numeric($number, $small = false, $large = false, $equalTo = false, $optional = false) {
		try {
		//See if the string is empty
			!$optional && empty($number) && !is_numeric($number) ? $error = "A required value was empty." : true;
			
			if ($optional && empty($number)) {
				return $number;
			}
			
		//Is it big enough?
			if (is_numeric($small) && !is_numeric($large) && $number < $small) {
				$error = "A required value was too small. The numeric value must be greater than or equal to <strong>" . $small . "</strong>.";
		//Is it small enough?
			} elseif (is_numeric($large) && !is_numeric($small) && $number > $large) {
				$error = "A required value was too large. The numeric value must be less than or equal to <strong>" . $large . "</strong>.";
		//Is it between a given range?
			} elseif (is_numeric($small) && is_numeric($large) && $small < $large && ($number < $small || $number > $large)) {
				$error = "A required value was not within the specified range. The numeric value must be between <strong>" . $small . "</strong> and <strong>" . $large . "</strong>.";
		//Is is equal to a given length?
			} elseif (is_numeric($equalTo) && $number !== $equalTo) {
				$error = "A required value was not within the specified range. The numeric value must be equal to <strong>" . $equalTo . "</strong>.";
			}
			
			if (isset($error)) {
				throw new Exception($error);
			} else {
				return $number;
			}
		} catch (Exception $e) {
			die($e->getMessage() . self::$redirect);
		}
	}
	
/**
 * Check to see if the supplied value is an array. This method is also able to
 * perform other tests on an array, as described in each of the @param
 * annotations below.
 *
 * @param      array       $array      The array to validate
 * @param      int         $sizeSmall  The smallest length the array may equal
 * @param      int         $sizeLarge  The smallest length the array may equal
 * @param      int         $sizeEquals The only length the array may equal
 * @param      boolean     $optional   Whether or not $array is required. This is useful you only wish to use the above testing conditions on $array.
 * @access     public
 * @return     void
 * @since      v0.1 Dev
 */
	public static function isArray($array, $sizeSmall = false, $sizeLarge = false, $sizeEquals = false, $optional = false) {
		try {
		//See if the string is empty
			!$optional && (empty($number) || !is_array($array) || sizeof($array) == 0) ? $error = "A required value was empty." : true;
		} catch (Exception $e) {
			
		}
		
		if (!empty($array) && is_array($array) && count($array) == $size) {
			$return = array();
			
			for($count = 0; $count <= count($array); $count ++) {
				array_push($return, self::required($array[$count]));
			}
			
			return $return;
		} else {
			die("A required value was empty." . self::$redirect);
		}
	}
	
/**
 * Check to see if the file from a certain form input was uploaded
 *
 * @param      string      $file     The name of the input field containing the presumed uploaded file to validate
 * @param      boolean     $optional Whether or not $file is required.
 * @access     public
 * @return     void
 * @since      v0.1 Dev
 */
	
//Check to see if a file was uploaded
	public static function isUploaded($file, $optional = false) {
		if ($optional && empty($file)) {
			return $file;
		}
		
		if (is_uploaded_file($_FILES[$file]['tmp_name']) || !$optional) {
			return $file;
		} else {
			die("A required file was not uploaded." . self::$redirect);
		}
	}
	
/**
 * Check to see if the given input is an email address
 *
 * @param      string      $email    The string to validate
 * @param      boolean     $optional Whether or not $email is required.
 * @access     public
 * @return     void
 * @since      v0.1 Dev
 */
	public static function isEmail($email, $optional = false) {
		 $pattern = "/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD";
		 
		 if ($optional && empty($email)) {
		 	return $email;
		 }
		 
		 if (self::required($email) && !preg_match("/[\\000-\\037]/", $email) && preg_match($pattern, $email)) {
		 	return $email;
		 } else {
		 	die("An invalid email address was entered." . self::$redirect);
		 }
	}
}
?>