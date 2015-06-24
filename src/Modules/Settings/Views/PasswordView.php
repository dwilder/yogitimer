<?php
namespace Src\Modules\Settings\Views;

use Src\Includes\SuperClasses\View;
use Src\Includes\Form\Form;

class PasswordView extends View
{
	/*
	 * Store title
	 */
	protected $title = 'Change Password';
	
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
		
		$content .= '<p>Please enter your current password to choose a new password.</p>';
		
        $content .= $this->formMessage();
        
		$this->form = new Form;
		$this->buildForm();
		$content .= $this->form->getHTML();
		
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
		$pass = $this->form->newInput( 'password' );
		$pass->setLabel( 'Current Password' );
		$pass->set( 'name', 'pass' );
		$pass->set( 'id', 'pass' );
        if ( isset( $this->data['error']['pass'] ) ) $pass->setError( $this->data['error']['pass'] );

		$new_pass = $this->form->newInput( 'password' );
		$new_pass->setLabel( 'New Password' );
		$new_pass->set( 'name', 'new_pass' );
		$new_pass->set( 'id', 'new_pass' );
        if ( isset( $this->data['error']['new_pass'] ) ) $new_pass->setError( $this->data['error']['new_pass'] );

		$confirm_pass = $this->form->newInput( 'password' );
		$confirm_pass->setLabel( 'Confirm Password' );
		$confirm_pass->set( 'name', 'confirm_pass' );
		$confirm_pass->set( 'id', 'confirm_pass' );
        if ( isset( $this->data['error']['confirm_pass'] ) ) $confirm_pass->setError( $this->data['error']['confirm_pass'] );
		
		$save = $this->form->newInput( 'submit' );
		$save->set( 'name', 'submit' );
		$save->set( 'id', 'submit' );
		$save->set( 'value', 'Save Changes' );
        
        $cancel = $this->form->newHtml( 'p', '<a href="/settings/password">Cancel</a>' );
        $cancel->set( 'class', 'form-link-cancel' );
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