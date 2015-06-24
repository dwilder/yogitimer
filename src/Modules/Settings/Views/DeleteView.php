<?php
namespace Src\Modules\Settings\Views;

use Src\Includes\SuperClasses\View;
use Src\Includes\Form\Form;

class DeleteView extends View
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
	 * Return the content
	 */
	public function run()
	{
		$content = $this->getTitle();
		
		$content .= '<p>Are you sure you want to delete your account? You will lose all your meditation data.</p>';
		
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
		$delete = $this->form->newInput( 'submit' );
		$delete->set( 'name', 'submit' );
		$delete->set( 'id', 'submit' );
		$delete->set( 'value', 'Delete' );
        
        $cancel = $this->form->newHtml( 'p', '<a href="/settings">Cancel</a>' );
        $cancel->set( 'class', 'form-link-cancel' );
	}
	
	/*
	 * Create a cancel link
	 */
	protected function cancelLink()
	{
		return '<p class="form-link-cancel"><a href="/settings">Cancel</a></p>';
	}
}