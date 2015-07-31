<?php
namespace Src\Modules\Practices\Views;

use Src\Includes\SuperClasses\View;
use Src\Includes\Form\Form;

/*
 * Creates the form for the Add and Edit views
 */
class AbstractActionForm extends View
{
	/*
	 * Store the title
	 */
	protected $title;
	
	/*
	 * Store the form
	 */
	protected $form;
	
	/*
	 * Store the content
	 */
	protected $content;
	
	/*
	 * Get the content
	 */
	public function getContent()
	{
		return $this->content;
	}
	
	/*
	 * Set the content
	 */
	public function run()
	{
		$content = $this->getTitle();
        
        if ( $this->success() ) {
            $content .= '<p class="form-success">Your practice has been updated.</p>';
        }
		
        if ( isset( $this->data['error']['form'] ) ) {
            $content .= '<p class="form-error">' . $this->data['error']['form'] . '</p>';
        }
		$this->form = new Form;
		$this->buildForm();
		$content .= $this->form->getHtml();
		
		// Add the delete link
		if ( isset( $this->data['id'] ) ) {
			//$content .= $this->deleteLink();
		}
		
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
     * Check for a success message
     */
    protected function success()
    {
        if ( isset( $this->data['status'] ) && $this->data['status'] == 'SUCCESS' ) {
            return true;
        }
        return false;
    }
	
	/*
	 * Create the form
	 */
	protected function buildForm()
	{	
		$name = $this->form->newInput( 'text' );
		$name->setLabel( 'Name your practice' );
		$name->set( 'name', 'name' );
		$name->set( 'id', 'name' );
		$name->set( 'placeholder', 'Shamatha' );
		( isset( $this->data['name'] ) ) && $name->set('value', $this->data['name']);
		( isset( $this->data['error']['name'] ) ) && $name->setError($this->data['error']['name']);

		$time = $this->form->newInput( 'text' );
		$time->setLabel( 'Goal' );
		$time->set( 'name', 'goal_time' );
		$time->set( 'id', 'goal_time' );
		$time->set( 'placeholder', '0 ' );
        $time->setHelp('You can set a goal for the number of hours for this practice or leave it blank.');
		( isset( $this->data['goal_time'] ) ) && $time->set('value', $this->data['goal_time']);
		( isset( $this->data['error']['goal_time'] ) ) && $date->setError($this->data['error']['goal_time']);
		
		if ( isset( $this->data['mid'] ) ) {
			$mid = $this->form->newInput( 'hidden' );
			$mid->set( 'name', 'mid' );
			$mid->set( 'id', 'mid' );
			$mid->set( 'value', $this->data['mid'] );
		}
		
		$submit = $this->form->newInput( 'submit' );
		$submit->set( 'name', 'submit' );
		$submit->set( 'id', 'submit' );
		$submit->set( 'value', 'Save' );
        
        $cancel = $this->form->newHtml( 'p', '<a href="/practices">Cancel</a>' );
        $cancel->set( 'class', 'form-link-cancel' );
	}
	
	
	/*
	 * Create the correct text to show to break up minutes into hours
	 */
	protected function getTimeSelectorText( $time )
	{
		$text = '';
		if ( $time >= 60 ) {
			$text .= floor( $time / 60 );
			$text .= ( floor( $time/60 ) == 1 ) ? " Hour " : " Hours ";
		}
		if ( $time % 60 ) {
			$text .= ( $time % 60 );
			$text .= ( $time % 60 == 1 ) ? " Minute " : " Minutes ";
		}
		
		return $text;
	}
	
	/*
	 * Create a delete link
	 */
	protected function deleteLink()
	{
		return '<p class="form-link-delete"><a href="/practices/delete/' . $this->data['id'] . '">Delete Meditation Time</a></p>';
	}
}