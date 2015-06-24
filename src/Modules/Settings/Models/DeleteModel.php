<?php
namespace Src\Modules\Settings\Models;

use Src\Includes\SuperClasses\Model;
use Src\Includes\User\User;

class DeleteModel extends Model
{	
	/*
	 * Set the data
	 */
	public function run()
	{
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    		$this->deleteUser();
        }
	}
    
    /*
     * Delete the user
     */
    private function deleteUser()
    {
        $user = User::getInstance();
        
        if ( $user->delete() ) {
            // $this->sendDeleteConfirmationEmail();
            $this->redirect('logout');
        }
    }
    
    /*
     * Send an email to confirm the account deletion
     */
    private function sendDeleteConfirmationEmail()
    {
        
    }
}