<?php
namespace Src\Modules\SignUp;

use Src\Includes\Module\MultiUIController;

/*
 * Controller class for signing up.
 *
 * - Sign Up			/signup
 * - Sign Up Thank You	/signup/success
 * - Activation			/activate/[email]/[token]
 */

class Controller extends MultiUIController
{
    /*
     * Set the module name
     */
    protected function setModuleName()
    {
        $this->module_name = 'SignUp';
    }
    
    /*
     * A method to get the class
     */
    protected function getClass()
    {
		switch( $this->guid ) {
			case 'activate':
				$class = 'Activation';
				break;
			case 'signup':
			default:
				if ( $_GET['action'] == 'success' ) {
					$class = 'SignUpComplete';
				} else {
					$class = 'SignUp';
				}
				break;
		}
        return $class;
    }
}