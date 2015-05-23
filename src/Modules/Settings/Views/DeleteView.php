<?php
namespace Src\Modules\Settings\Views;

use Src\Includes\Form\Form;

class DeleteView
{
	/*
	 * Store title
	 */
	protected $title = 'Delete Account';
	
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
		
		$content .= '<p>Are you sure you want to delete your account? You will lose all your meditation data.</p>';
		
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
		$delete = $this->form->newInput( 'submit' );
		$delete->set( 'name', 'submit' );
		$delete->set( 'id', 'submit' );
		$delete->set( 'value', 'Delete' );
	}
	
	/*
	 * Create a cancel link
	 */
	protected function cancelLink()
	{
		return '<p class="form-link-cancel"><a href="/settings">Cancel</a></p>';
	}
}