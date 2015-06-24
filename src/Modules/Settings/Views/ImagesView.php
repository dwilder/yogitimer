<?php
namespace Src\Modules\Settings\Views;

use Src\Includes\SuperClasses\View;
use Src\Includes\Form\Form;

class ImagesView extends View
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
	 * Return the content
	 */
	public function run()
	{
		$content = $this->getTitle();
		
		$content .= '<p>You can upload a profile photo and a background photo.</p>';
		
		$this->form = new Form;
        $this->form->enableFileUploading();
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
		$profile = $this->form->newInput( 'file' );
		$profile->setLabel( 'Profile Photo' );
		$profile->set( 'name', 'profile' );
		$profile->set( 'id', 'profile' );
		
		$profile_photo = $this->form->newHtml( 'img', $this->data['profile'] );

		$banner = $this->form->newInput( 'file' );
		$banner->setLabel( 'Banner Photo' );
		$banner->set( 'name', 'banner' );
		$banner->set( 'id', 'banner' );
		
		$banner_photo = $this->form->newHtml( 'img', $this->data['banner'] );
		
		$save = $this->form->newInput( 'submit' );
		$save->set( 'name', 'submit' );
		$save->set( 'id', 'submit' );
		$save->set( 'value', 'Save Changes' );
        
        $cancel = $this->form->newHtml( 'p', '<a href="/settings/images">Cancel</a>' );
        $cancel->set( 'class', 'form-link-cancel' );
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