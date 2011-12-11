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
 * Create and maintain the configuration of the system core.
 *
 * @category Core
 * @package <none>
 * @since v0.1 Dev
 */

class Config {
//Database connection configuration
	public $dbHost = "localhost";
	public $dbPort = "3306";
	public $dbUserName = "root";
	public $dbPassword = "Oliver99";
	public $dbName = "2mj";
	
/* Installation directory configuration
 * "$installDomain" is the domain name (without the http://www) followed by the installation path.
 * "$installRoot" is the installation path relative the root of the server.
*/
	public $installDomain = "localhost/2mj/";
	public $installRoot = "/Web Development/wamp/www/2mj/";
	
//Security settings configuration
	public $folderPermissions = "0777";
	public $encryptedSalt = "%(*&NSJ(&jd&81245";
	public $sessionSuffix = "HJF789HF6";
}
?>