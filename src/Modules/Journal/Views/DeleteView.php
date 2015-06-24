<?php
namespace Src\Modules\Journal\Views;

use Src\Includes\SuperClasses\View;
use Src\Includes\Form\Form;
use Src\Modules\Journal\Helpers\tNotFound;

class DeleteView extends View
{
    use tNotFound;
    
	/*
	 * Page title
	 */
	protected $title = 'Delete Meditation Time';
	
	/*
	 * Set the content
	 */
	public function run()
	{
		if ( $this->notFound() ) {
		    $this->setNotFoundContent();
		}
        else {
            $this->setFormContent();
        }
	}
    
	/*
	 * Set the content
	 */
	protected function setFormContent()
	{
		$content = $this->getTitle();
		
        if ( isset( $this->data['error']['form'] ) ) {
            $content .= '<p class="form-error">' . $this->data['error']['form'] . '</p>';
        }
        
		$content .= '<p>Are you sure you want to delete your meditation time on <b>';
		$content .= $this->data['long_date'];
		$content .= '</b>?</p>';
		
		$this->form = new Form;
		$this->buildForm();
		$content .= $this->form->getHtml();
		
		$this->content = $content;
	}
	
	/*
	 * Build the title
	 */
	protected function getTitle()
	{
		return "<h1>{$this->title}</h1>";
	}
	
	/*
	 * Create the form
	 */
	protected function buildForm()
	{	
		$mid = $this->form->newInput( 'hidden' );
		$mid->set( 'name', 'mid' );
		$mid->set( 'id', 'mid' );
		$mid->set( 'value', $this->data['id'] );
		
		$submit = $this->form->newInput( 'submit' );
		$submit->set( 'name', 'submit' );
		$submit->set( 'id', 'submit' );
		$submit->set( 'value', 'Delete' );
        
        $cancel = $this->form->newHtml( 'p', '<a href="/journal/edit/' . $this->data['id'] . '">Cancel</a>' );
        $cancel->set( 'class', 'form-link-cancel' );
	}
	
	/*
	 * Create a cancel link
	 */
	protected function cancelLink()
	{
		return '<p class="form-link-cancel"><a href="/journal/edit/' . $this->data['id'] . '">Cancel</a></p>';
	}
}