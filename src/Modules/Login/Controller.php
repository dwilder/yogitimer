<?php
namespace Src\Modules\Login;

use Src\Includes\SuperClasses\UIController;
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

class Controller extends UIController
{
    /*
     * Figure out which class to use
     */
    protected function setClass()
    {
		switch ( $this->request['guid'] ) {
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
        $this->class = $class;
    }
}