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
 * A simple class which will send a message to the user in the event of a success
 * or error event.
 *
 * @category Core
 * @package core
 * @since v0.1 Dev
 */
 
class Message {
/**
 * Track whether or not an inline stylesheet or the external stylesheet should be
 * used. If this is set to false, then the external stylesheet will not be used, 
 * and will be generated inline.
 *
 * @access     private
 * @var        boolean
 */
	private $useStyleSheet = false;
	
/**
 * Check to see if the message boxes should be styled using inline styles, or
 * external stylesheets by using the constructor method. The only time inline
 * styles should be used is when the system is displaying a fatal error which
 * occured before the page content could be generated.
 *
 * @param      boolean     $input     A boolean indicating whether or not an inline stylesheet should be used
 * @access     public
 * @return     void
 * @since      v0.1 Dev
 */
	public function __construct($input) {
		$this->useStyleSheet = $input;
	}
	
/**
 * Render a success output message
 *
 * @param      boolean     $message   The message to display
 * @access     public
 * @return     void
 * @since      v0.1 Dev
 */
	public function success($message) {
	//Build the CSS, if needed
		if (!$this->useStyleSheet) {
			$return = "<style>
  .ui-widget { font-family: Verdana,Arial,sans-serif; font-size: 1.1em; }
  .ui-state-highlight { border: 1px solid #fcefa1; background: #fbf9ee url(" . ROOT . "system/images/jQuery_UI/ui-bg_glass_55_fbf9ee_1x400.png) 50% 50% repeat-x; color: #363636; }
  .ui-corner-all { -moz-border-radius: 4px; -webkit-border-radius: 4px; }
  .ui-icon { width: 16px; height: 16px; background-image: url(" . ROOT . "system/images/jQuery_UI/ui-icons_222222_256x240.png); }
  .ui-icon-info { background-position: -16px -144px; }
</style>";
		} else {
			$return = "";
		}
		
	//Display the message
		$return .= "
<section class=\"ui-widget\">
<div class=\"ui-state-highlight ui-corner-all\" style=\"margin-top: 20px; padding: 0pt 0.7em;\"> 
<p><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: 0.3em;\"></span>
" . $message . "</p>
</div>
</section>";
			
		echo $return;
	}
	
/**
 * Render an error output message
 *
 * @param      boolean     $message   The message to display
 * @access     public
 * @return     void
 * @since      v0.1 Dev
 */
	public function error($message) {
	//Build the CSS, if needed
		if (!$this->useStyleSheet) {
			$return = "<style>
  .ui-widget { font-family: Verdana,Arial,sans-serif; font-size: 1.1em; }
  .ui-state-error { border: 1px solid #cd0a0a; background: #fef1ec url(" . ROOT . "system/images/jQuery_UI/ui-bg_glass_95_fef1ec_1x400.png) 50% bottom repeat-x; color: #cd0a0a; }
  .ui-corner-all { -moz-border-radius: 4px; -webkit-border-radius: 4px; }
  .ui-icon { width: 16px; height: 16px; background-image: url(" . ROOT . "system/images/jQuery_UI/ui-icons_222222_256x240.png); }
  .ui-icon-alert { background-position: 0 -144px; }
</style>";
		} else {
			$return = "";
		}
		
	//Display the message
		$return .= "
<section class=\"ui-widget\">
<div class=\"ui-state-error ui-corner-all\" style=\"margin-top: 20px; padding: 0pt 0.7em;\"> 
<p><span class=\"ui-icon ui-icon-alert\" style=\"float: left; margin-right: 0.3em;\"></span>
" . $message . "</p>
</div>
</section>";
		
		echo $return;
	}
}
	
//Instantiate the "Message" class to allow the system to easily display messages to the user.
	$message = new Message(true);
?>