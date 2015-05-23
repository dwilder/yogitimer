<?php
namespace Src\Modules\Settings\Views;

use Src\Includes\Form\Form;

class PasswordView
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
	 * Store data
	 */
	protected $data = array();
	
	/*
	 * Set the data
	 */
	public function setData( array $data = array() )
	{
		$this->data = $data;
	}
	
	/*
	 * Return the content
	 */
	public function getContent()
	{
		$content = $this->getTitle();
		
		$content .= '<p>Please enter your current password to choose a new password.</p>';
		
		$this->form = new Form;
		$this->buildForm();
		$content .= $this->form->getHTML();
		
		$content .= $this->cancelLink();
		
		return $content;
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

		$new_pass = $this->form->newInput( 'password' );
		$new_pass->setLabel( 'New Password' );
		$new_pass->set( 'name', 'new_pass' );
		$new_pass->set( 'id', 'new_pass' );

		$confirm_pass = $this->form->newInput( 'password' );
		$confirm_pass->setLabel( 'Confirm Password' );
		$confirm_pass->set( 'name', 'confirm_pass' );
		$confirm_pass->set( 'id', 'confirm_pass' );
		
		$save = $this->form->newInput( 'submit' );
		$save->set( 'name', 'submit' );
		$save->set( 'id', 'submit' );
		$save->set( 'value', 'Save Changes' );
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