<?php
namespace Src\Modules\Login\Views;

use Src\Lib\Form\Form;

class ResetPasswordView
{
	/*
	 * Set the title
	 */
	protected $title = 'Reset Password';
	
	/*
	 * Store the content
	 */
	protected $content;
	
	/*
	 * Store the form
	 */
	protected $Form;
	
    /*
     * Store data
     */
    protected $data = array();
    
    /*
     * Access status
     */
    private $status;
    
    /*
     * Set data
     */
    public function setData( $data = array() )
    {
        $this->data = $data;
    }
    
	/*
	 * Get the content
	 */
	public function getContent()
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
		
		return $this->content;
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
		$newpass->set( 'name', 'newpass' );
		$newpass->set( 'id', 'newpass' );
        ( ! isset( $this->data['error']['new_password'] ) ) || $newpass->setError( $this->data['error']['new_password'] );

		$confirmpass = $this->Form->newInput( 'password' );
		$confirmpass->setLabel( 'Confirm Password' );
		$confirmpass->set( 'name', 'confirmpass' );
		$confirmpass->set( 'id', 'confirmpass' );
        ( ! isset( $this->data['error']['confirm_password'] ) ) || $newpass->setError( $this->data['error']['confirm_password'] );
		
		$submit = $this->Form->newInput( 'submit' );
		$submit->set( 'name', 'submit' );
		$submit->set( 'id', 'submit' );
		$submit->set( 'value', 'Submit' );
	}
	
}