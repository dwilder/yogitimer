<?php
namespace Src\Modules\Settings\Views;

use Src\Includes\SuperClasses\View;
use Src\Includes\Form\Form;

class PersonalView extends View
{
	/*
	 * Store title
	 */
	protected $title = 'Personal Settings';
	
	/*
	 * Store the form
	 */
	protected $form;
	
	/*
	 * Return the content
	 */
	public function run()
	{
		$content = $this->getTitle();
		
		$content .= '<p>Change your username and email address.</p>';
		
        $content .= $this->formMessage();
        
		$this->form = new Form;
		$this->buildForm();
		$content .= $this->form->getHTML();
		
		$content .= $this->cancelLink();
		$content .= $this->deleteLink();
		
		$this->content = $content;
	}
	
	/*
	 * Get the title
	 */
	protected function getTitle()
	{
		return "<h1>{$this->title}</h1>";
	}
	
	/*
	 * Build the form
	 */
	protected function buildForm()
	{
		$username = $this->form->newInput( 'text' );
		$username->setLabel( 'Username' );
		$username->set( 'name', 'username' );
		$username->set( 'id', 'username' );
		$username->set( 'value', $this->data['username'] );
        ( isset( $this->data['error']['username'] ) ) ? $username->setError( $this->data['error']['username'] ) : null;

		$email = $this->form->newInput( 'email' );
		$email->setLabel( 'Email address' );
		$email->set( 'name', 'email' );
		$email->set( 'id', 'email' );
		$email->set( 'value', $this->data['email'] );
        ( isset( $this->data['error']['email'] ) ) ? $email->setError( $this->data['error']['email'] ) : null;
		
		$save = $this->form->newInput( 'submit' );
		$save->set( 'name', 'submit' );
		$save->set( 'id', 'submit' );
		$save->set( 'value', 'Save Changes' );
	}
    
    /*
     * Create a success or failure message as needed
     */
    protected function formMessage()
    {   
        $message = '';
        if ( isset( $this->data['success'] ) ) {
            $message .= '<p class="form-success">Your settings been updated.</p>';
        }

        if ( isset( $this->data['error']['form'] ) ) {
            $message .= '<p class="form-error">' . $this->data['error']['form'] . '</p>';
        }
        elseif ( isset( $this->data['error'] ) && ! empty( $this->data['error'] ) ) {
            $message .= '<p class="form-error">Please check for errors.</p>';
        }
        
        return $message;
    }
	
	/*
	 * Create a cancel link
	 */
	protected function cancelLink()
	{
		return '<p class="form-link-cancel"><a href="/settings">Cancel</a></p>';
	}
	
	/*
	 * Create a delete link
	 */
	protected function deleteLink()
	{
		return '<p class="form-link-delete"><a href="/settings/delete">Delete Account</a></p>';
	}
}