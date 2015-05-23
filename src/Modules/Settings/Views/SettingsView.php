<?php
namespace Src\Modules\Settings\Views;

use Src\Includes\Form\Form;

class SettingsView
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
		
		$content .= '<p>Change your username and email address.</p>';
		
		$this->form = new Form;
		$this->buildForm();
		$content .= $this->form->getHTML();
		
		$content .= $this->cancelLink();
		$content .= $this->deleteLink();
		
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
		$username = $this->form->newInput( 'text' );
		$username->setLabel( 'Username' );
		$username->set( 'name', 'username' );
		$username->set( 'id', 'username' );
		$username->set( 'value', $this->data['username'] );

		$email = $this->form->newInput( 'email' );
		$email->setLabel( 'Email address' );
		$email->set( 'name', 'email' );
		$email->set( 'id', 'email' );
		$email->set( 'value', $this->data['email'] );
		
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