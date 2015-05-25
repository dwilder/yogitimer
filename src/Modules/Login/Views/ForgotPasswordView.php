<?php
namespace Src\Modules\Login\Views;

use Src\Includes\SuperClasses\View;
use Src\Includes\Form\Form;

class ForgotPasswordView extends View
{
	/*
	 * Set the title
	 */
	protected $title = 'Forgot Password';
	
	/*
	 * Store the form
	 */
	protected $form;
	
	/*
	 * Get the content
	 */
	public function run()
	{
        if ( isset( $this->data['success'] ) ) {
            $this->setSuccessContent();
        } else {
    		$this->setContent();
        }
	}
	
    /*
     * Set success content
     */
    protected function setSuccessContent()
    {
        $this->title = "Help is on the way!";
        
        $content = $this->getTitle();
        
        $content .= "<p>Please check your email account for instructions to change your password. If that fails, try again or contact support.<p>";
        $content .= '<p><a href="/forgotpassword">Try again?</a></p>';
        
        $this->content = $content;
    }
	/*
	 * Build the title
	 */
	protected function getTitle()
	{
		return "<h1>{$this->title}</h1>";
	}
	
	/*
	 * Set the content
	 */
	public function setContent()
	{
		$content = $this->getTitle();
		$content .= '<p>Enter your email address or username and we\'ll send you instructions for resetting your password.</p>';
		
		$this->Form = new Form;
		$this->buildForm();
		$content .= $this->Form->getHTML();
		
		$content .= '<p><a href="/login">Login</a></p>';
		
		$this->content = $content;
	}
	
	/*
	 * Build the form
	 */
	protected function buildForm()
	{
		$username = $this->Form->newInput( 'email' );
		$username->setLabel( 'Username or Email' );
		$username->set( 'name', 'username' );
		$username->set( 'id', 'username' );
        ( ! isset( $this->data['username'] ) ) || $username->set( 'value', $this->data['username'] );
        ( ! isset( $this->data['error']['username'] ) ) || $username->setError( $this->data['error']['username'] );
		
		$submit = $this->Form->newInput( 'submit' );
		$submit->set( 'name', 'submit' );
		$submit->set( 'id', 'submit' );
		$submit->set( 'value', 'Send' );
	}
}