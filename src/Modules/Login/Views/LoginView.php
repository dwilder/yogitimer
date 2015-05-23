<?php
namespace Src\Modules\Login\Views;

use Src\Includes\Form\Form;

class LoginView
{
	/*
	 * Set the title
	 */
	protected $title = 'Log In';
	
	/*
	 * Store the content
	 */
	protected $content;
	
	/*
	 * Store submitted data
	 */
	protected $data = array();
	
	
	/*
	 * Store the form
	 */
	protected $form;
	
	/*
	 * Set the data
	 */
	public function setData( array $data )
	{
		$this->data = $data;
	}
    
	/*
	 * Get the content
	 */
	public function getContent()
	{
		$this->setContent();
		
		return $this->content;
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
		
        // Form errors
        if ( isset( $this->data['error']['form'] ) ) {
            $content .= '<p class="error">';
            $content .= $this->data['error']['form'];
            $content .= '</p>';
        }
		$this->form = new Form;
		$this->buildForm();
		$content .= $this->form->getHTML();
		
		$content .= '<p>Need an account? <a href="/signup">Sign Up</a></p>';
		
		$this->content = $content;
	}
	
	/*
	 * Build the form
	 */
	protected function buildForm()
	{
		$username = $this->form->newInput( 'email' );
		$username->setLabel( 'Username or Email' );
		$username->set( 'name', 'username' );
		$username->set( 'id', 'username' );
        ( ! isset( $this->data['username'] ) ) || $username->set( 'value', $this->data['username'] );
        ( ! isset( $this->data['error']['username'] ) ) || $username->setError( $this->data['error']['username'] );
        
		
		$pass = $this->form->newInput( 'password' );
		$pass->setLabel( 'Password' );
		$pass->set( 'name', 'pass' );
		$pass->set( 'id', 'pass' );
		$pass->setHelp( '<a href="forgotpassword">Forgot?</a>' );
        ( ! isset( $this->data['error']['password'] ) ) || $pass->setError( $this->data['error']['password'] );
		
		$submit = $this->form->newInput( 'submit' );
		$submit->set( 'name', 'submit' );
		$submit->set( 'id', 'submit' );
		$submit->set( 'value', 'Log In' );
	}
}