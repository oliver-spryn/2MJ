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

/*
 * This script is the super core of the system, which prepares the values from the
 * configuration script for use within the system. Here is an overview of this
 * relatively simple script:
 *  [1] The server is examined to see which operating system it is running, and will
 *      then define a constant giving the name of the operating system, and whether or
 *      not the operating system is Windows or *nix, to the rest of the application.
 *  [2] The server checks to see if at least PHP 5 is running, and also defines several
 *      constants which will make the major and minor versions avaliable to the
 *      system.
 *  [3] Check to see if the configuration script exists, and alert the user to install
 *      the application if it does not.
 *  [4] Instantiate the "Config" class for use through out this script and system.
 *  [5] Check to see if the browser made a request via the HTTPS protocol, and set a
 *      constant to track this and other URL-related data.
 *  [6] Include the essential classes within the system's core.
 *  [7] Start a session.
 *  [8] Set several several configurations which will boost performance, improve
 *  	security, and allow certain actions.
 *  [9] Create a function which be used to import additional classes and packages into
 *  	a script for parsing, using ECMAScript standards.
 */
 
//Check for the operating system that the server is running
	define("SERVER_OS", php_uname("s"));
	define("IS_WINDOWS", SERVER_OS == "Windows NT" ? true : false);
	
//This system requires a minimum of PHP 5, so ensure that this condition is true before doing else anything!
	define("PHP_MINOR_VER",  phpversion());
	define("PHP_MAJOR_VER", current(explode(".", PHP_MINOR_VER)));
	PHP_MAJOR_VER < 5 ? die("Please install PHP 5 or greater in order to use this application.") : NULL;
	
//Check to see if the system has been setup. If so, the configuration script will exist, and it can be imported, otherwise prompt the user to install.
	if (IS_WINDOWS) {
		$configScript = str_replace("system\server", "", dirname(__FILE__)) . "data\system\Config.php";
	} else {
		$configScript = str_replace("system/server", "", dirname(__FILE__)) . "data/system/Config.php";
	}
	
	if (file_exists($configScript)) {
		require_once($configScript);
		unset($configScript);
	} else {
		echo "Please install this application before continuing.";
		exit;
	}
	
//Instantiate the "Config" class
	$config = new Config();
	
//Detirmine the root address for the entire site, and include the "http://" if SSL is not active and "https://" if SSL is active
	isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on" ? define("PROTOCOL", "https://") : define("PROTOCOL", "http://");
	define("ROOT", PROTOCOL . $config->installDomain);
	define("STRIPPED_ROOT", $config->installDomain);
	
//Include the rest of the system's core. The order of the files in the "$include" array are important! Do not rearrange the order!
	$include = array("core/Message.php", "core/Validate.php", "core/Database.php");
	
	foreach($include as $script) {
		require_once($config->installRoot . "system/server/" . $script);
	}
	
//Start the session
	session_save_path($config->installRoot . "data/system/sessions");
	session_name("2MJ_" . $config->sessionSuffix);
	session_start();
	
//Set server configurations
	set_time_limit(3600);
	error_reporting(0);
	
/**
 * Import additional classes and packages into a script for parsing, by using
 * ECMAScript standards (e.g. import(package.class))
 * 
 * @param      string      $classes     The ECMAScript-style path to a given class or package to import
 * @return     boolean     An indicator as whether or not importing was a success
 * @since      v0.1 Dev
 */
	function import($path) {
		global $config, $message;
		
		$importAll = explode(".", $path);
		
	//Import an entire package
		if ($importAll[count($importAll) - 1] == "*") {
			$modifiedPath = $config->installRoot . "system/server/";
			
		//- 2 from the iterator, so that the "*" isn't included
			for ($i = 0; $i <= count($importAll) - 2; $i ++) {
				$modifiedPath .= $importAll[$i] . "/";
			}
			
		//Check to see if the package exists
			if (!is_dir($modifiedPath)) {
				$message->error("<strong>Fatal error:</strong> The system could not import the following classes, because either the package name is incorrect or it does not exist:\n<br /><br />\n" . $path . "\n<br /><br />");
				
				return false;
				exit;
			}
			
			$packageHandler = opendir($modifiedPath);
			
		//Get all of the classes from the package
			while (false !== ($packageContents = readdir($packageHandler))) {
			//Exclude ".", "..", and any dot files or dot directories
				if (strpos($packageContents, ".") !== 0) {
					require_once($modifiedPath . $packageContents);
					return true;
				}
			}
			
			closedir($packageHandler);
	//Import a single class
		} else {
			$modifiedPath = $config->installRoot . "system/server/" . str_replace(".", "/", $path) . ".php";
			
		//Check to see if the package and class exist
			if (file_exists($modifiedPath)) {
				require_once($modifiedPath);
				return true;
			} else {
				$message->error("<strong>Fatal error:</strong> The system could not import the following class, because either the package or class name is incorrect or it does not exist:\n<br /><br />\n" . $path . "\n<br /><br />");
				
				return false;
				exit;
			}
		}
	}
?>