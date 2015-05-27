<?php
namespace Src\Modules\Settings;

use Src\Includes\SuperClasses\UIController;

/*
 * Controller class for the user settings section.
 *
 * - Personal Settings
 * - Delete Account
 * - Profile Images
 * - Change Password
 */

class Controller extends UIController
{
	/*
	 * Check for an action
	 */
	protected function setClass()
	{
        $default = 'Personal';
        
		if ( isset( $this->request['action'] ) ) {

    		switch ( $this->request['action'] ) {
    			case 'delete':
    				$class = 'Delete';
    				break;
    			case 'images':
    				$class = 'Images';
    				break;
    			case 'password':
    				$class = 'Password';
    				break;
                case 'personal':
    			default:
    				$class = 'Personal';
    				break;
    		}
		}
        else {
            $class = $default;
        }
        
        $this->class = $class;
	}
}