<?php
namespace Src\Modules\Login;

use Src\Lib\Module\MultiUIController;
use Src\Modules\Login\Models\LoginModel;
use Src\Modules\Login\Models\ForgotPasswordModel;
use Src\Modules\Login\Models\ResetPasswordModel;
use Src\Modules\Login\Views\LoginView;
use Src\Modules\Login\Views\ForgotPasswordView;
use Src\Modules\Login\Views\ResetPasswordView;

/*
 * Controller class for the login section.
 *
 * - Login page
 * - Forgot Password
 * - Reset Password
 */

class Controller extends MultiUIController
{
    /*
     * Set the module name
     */
    protected function setModuleName()
    {
        $this->module_name = 'Login';
    }
    
    /*
     * Figure out which class to use
     */
    protected function getClass()
    {
		switch ( $this->guid ) {
			case 'forgotpassword';
				$class = 'ForgotPassword';
				break;
			case 'resetpassword';
				$class = 'ResetPassword';
				break;
			case 'login';
			default:
				$class = 'Login';
				break;
		}
        return $class;
    }
}