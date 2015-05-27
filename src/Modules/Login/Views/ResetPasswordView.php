<?php
namespace Src\Modules\Login\Views;

use Src\Includes\SuperClasses\View;
use Src\Includes\Form\Form;

class ResetPasswordView extends View
{
	/*
	 * Set the title
	 */
	protected $title = 'Reset Password';
	
	/*
	 * Store the form
	 */
	protected $Form;
	
    /*
     * Access status
     */
    private $status;
    
	/*
	 * Get the content
	 */
	public function run()
	{
        $this->setStatus();
        
        switch( $this->status ) {
            case 'valid':
                $this->setValidContent();
                break;
            case 'success':
                $this->setSuccessContent();
                break;
            case 'invalid':
            default:
                $this->setInvalidContent();
                break;
        }
	}
    
    /*
     * Set the status
     */
    private function setStatus()
    {
        if ( isset( $this->data['status'] ) ) {
            switch( $this->data['status'] ) {
                case 'SUCCESS':
                    $this->status = 'success';
                    break;
                case 'VALID':
                    $this->status = 'valid';
                    break;
                case 'INVALID':
                default:
                    $this->status = 'invalid';
                    break;
            }
            return;
        }
        $this->status = 'invalid';
    }
    
	/*
	 * Build the title
	 */
	protected function getTitle()
	{
		return "<h1>{$this->title}</h1>";
	}
    
    /*
     * Set success content
     */
    private function setSuccessContent()
    {
        $this->title = "Password Changed";
        
        $content = $this->getTitle();
        $content .= "<p>You're password has been successfully updated.</p>";
        $content .= '<p class="link-button"><a href="/meditate">Start Meditating</a></p>';
        
        $this->content = $content;
    }
    
    /*
     * Set invalid content
     */
    private function setInvalidContent()
    {
        $this->title = "Invalid Token";
        
        $content = $this->getTitle();
        $content .= '<p>The password reset token you are using is invalid. It may have expired. You can get a new one using the forgot password form.</p>';
        $content .= '<p><a href="/forgotpassword">Forgot Password?</a></p>';
        
        $this->content = $content;
    }
	
	/*
	 * Set valid content
	 */
	public function setValidContent()
	{
		$content = $this->getTitle();
		$content .= '<p>Create a new password for your account.</p>';
		
        $content .= $this->formMessage();
        
		$this->Form = new Form;
		$this->buildForm();
		$content .= $this->Form->getHTML();
		
		$this->content = $content;
	}
	
	/*
	 * Build the form
	 */
	protected function buildForm()
	{
		$newpass = $this->Form->newInput( 'password' );
		$newpass->setLabel( 'New Password' );
		$newpass->set( 'name', 'new_pass' );
		$newpass->set( 'id', 'new_pass' );
        ( ! isset( $this->data['error']['new_pass'] ) ) || $newpass->setError( $this->data['error']['new_pass'] );

		$confirmpass = $this->Form->newInput( 'password' );
		$confirmpass->setLabel( 'Confirm Password' );
		$confirmpass->set( 'name', 'confirm_pass' );
		$confirmpass->set( 'id', 'confirm_pass' );
        ( ! isset( $this->data['error']['confirm_pass'] ) ) || $confirmpass->setError( $this->data['error']['confirm_pass'] );
		
		$submit = $this->Form->newInput( 'submit' );
		$submit->set( 'name', 'submit' );
		$submit->set( 'id', 'submit' );
		$submit->set( 'value', 'Submit' );
	}
    
    /*
     * Create a success or failure message as needed
     */
    protected function formMessage()
    {   
        $message = '';
        if ( isset( $this->data['success'] ) ) {
            $message .= '<p class="form-success">Your password has been updated.</p>';
        }

        if ( isset( $this->data['error']['form'] ) ) {
            $message .= '<p class="form-error">' . $this->data['error']['form'] . '</p>';
        }
        elseif ( isset( $this->data['error'] ) && ! empty( $this->data['error'] ) ) {
            $message .= '<p class="form-error">Please check for errors.</p>';
        }
        
        return $message;
    }
}