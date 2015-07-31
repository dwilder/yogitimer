<?php
namespace Src\Modules\SignUp\Views;

use Src\Includes\Form\Form;

class SignUpView
{
	/*
	 * Set the title
	 */
	protected $title = 'Sign Up';
	
	/*
	 * Store the content
	 */
	protected $content;
	
	/*
	 * Store the form
	 */
	protected $Form;
	
	/*
	 * Store submitted data
	 */
	protected $data = array();
	
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
	public function run()
	{
		$content = $this->getTitle();
        // Form errors
        if ( isset( $this->data['error']['form'] ) ) {
            $content .= '<p class="error">';
            $content .= $this->data['error']['form'];
            $content .= '</p>';
        }
		$this->Form = new Form;
		$this->buildForm();
		$content .= $this->Form->getHTML();
		
		$content .= '<p>Have an account? <a href="/login">Sign In</a></p>';

		$this->content = $content;
	}
	
	/*
	 * Build the form
	 */
	protected function buildForm()
	{
		$username = $this->Form->newInput( 'text' );
		$username->setLabel( 'Username' );
		$username->set( 'name', 'username' );
		$username->set( 'id', 'username' );
		( !isset( $this->data['username'] ) ) || $username->set( 'value', $this->data['username'] );
		( !isset( $this->data['error']['username'] ) ) || $username->setError( $this->data['error']['username'] );
		
		$email = $this->Form->newInput( 'email' );
		$email->setLabel( 'Email address' );
		$email->set( 'name', 'email' );
		$email->set( 'id', 'email' );
		( !isset( $this->data['email'] ) ) || $email->set( 'value', $this->data['email'] );
		( !isset( $this->data['error']['email'] ) ) || $email->setError( $this->data['error']['email'] );
		
		$pass = $this->Form->newInput( 'password' );
		$pass->setLabel( 'Password' );
		$pass->set( 'name', 'pass' );
		$pass->set( 'id', 'pass' );
		( !isset( $this->data['error']['password'] ) ) || $pass->setError( $this->data['error']['password'] );
		
		$terms = $this->Form->newHtml( 'p', 'By joining, you agree to the <a href="/terms">terms</a> and <a href="privacy">privacy</a>.' );
		
		$submit = $this->Form->newInput( 'submit' );
		$submit->set( 'name', 'submit' );
		$submit->set( 'id', 'submit' );
		$submit->set( 'value', 'Join Yogi Timer' );
	}
}
