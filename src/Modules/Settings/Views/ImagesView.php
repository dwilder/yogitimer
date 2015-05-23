<?php
namespace Src\Modules\Settings\Views;

use Src\Includes\Form\Form;

class ImagesView
{
	/*
	 * Store title
	 */
	protected $title = 'Profile Images';
	
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
		
		$content .= '<p>You can upload a profile photo and a background photo.</p>';
		
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
		$profile = $this->form->newInput( 'file' );
		$profile->setLabel( 'Profile Photo' );
		$profile->set( 'name', 'profile' );
		$profile->set( 'id', 'profile' );
		
		$profile_photo = $this->form->newHtml( 'img', $this->data['profile_image'] );

		$background = $this->form->newInput( 'file' );
		$background->setLabel( 'Background Photo' );
		$background->set( 'name', 'background_image' );
		$background->set( 'id', 'background_image' );
		
		$background_photo = $this->form->newHtml( 'img', $this->data['background_image'] );
		
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
		return '<p class="form-link-cancel"><a href="/settings/images">Cancel</a></p>';
	}
	
	/*
	 * Create a delete link
	 */
	protected function deleteLink()
	{
		return '<p class="form-link-delete"><a href="/settings/delete">Delete Account</a></p>';
	}
}