<?php
namespace Src\Modules\Journal\Views;

use Src\Lib\Form\Form;

/*
 * Creates the form for the Add and Edit views
 */
class AbstractActionForm
{
	/*
	 * Store the title
	 */
	protected $title;
	
	/*
	 * Store the data
	 */
	protected $data = array();
	
	/*
	 * Store the form
	 */
	protected $form;
	
	/*
	 * Store the content
	 */
	protected $content;
	
	/*
	 * Set data from the model
	 */
	public function setData( array $data = array() )
	{
		$this->data = $data;
	}
	
	/*
	 * Get the content
	 */
	public function getContent()
	{
		$this->setContent();
		
		return $this->content;
	}
	
	/*
	 * Set the content
	 */
	protected function setContent()
	{
		$content = $this->getTitle();
        
        if ( $this->success() ) {
            $content .= '<p class="form-success">Your meditation has been updated.</p>';
        }
		
        if ( isset( $this->data['error']['form'] ) ) {
            $content .= '<p class="form-error">' . $this->data['error']['form'] . '</p>';
        }
		$this->form = new Form;
		$this->buildForm();
		$content .= $this->form->getHtml();
		
		// Add the cancel link
		$content .= $this->cancelLink();
		
		// Add the delete link
		if ( isset( $this->data['id'] ) ) {
			$content .= $this->deleteLink();
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
		$date = $this->form->newInput( 'date' );
		$date->setLabel( 'Date' );
		$date->set( 'name', 'date' );
		$date->set( 'id', 'date' );
		$date->set( 'placeholder', '31 01 2015' );
        $date->setHelp('dd mm yyyy');
		( isset( $this->data['date'] ) ) && $date->set('value', $this->data['date']);
		( isset( $this->data['error']['date'] ) ) && $date->setError($this->data['error']['date']);

		$time = $this->form->newInput( 'time' );
		$time->setLabel( 'Start Time' );
		$time->set( 'name', 'time' );
		$time->set( 'id', 'time' );
		$time->set( 'placeholder', '12:00 pm' );
        $time->setHelp('hh:mm am/pm');
		( isset( $this->data['time'] ) ) && $time->set('value', $this->data['time']);
		( isset( $this->data['error']['time'] ) ) && $date->setError($this->data['error']['time']);

		$duration = $this->form->newInput( 'select' );
		$duration->setLabel( 'Duration' );
		$duration->set( 'name', 'duration' );
		$duration->set( 'id', 'duration' );
		$duration->setOptions( $this->durationTimeOptions() );
		( isset( $this->data['duration'] ) ) && $duration->set('value', $this->data['duration']);
		
		if ( isset( $this->data['mid'] ) ) {
			$mid = $this->form->newInput( 'hidden' );
			$mid->set( 'name', 'mid' );
			$mid->set( 'id', 'mid' );
			$mid->set( 'value', $this->data['mid'] );
		}
        
        $add_method = $this->form->newInput( 'hidden' );
        $add_method->set('name', 'add_method');
        $add_method->set('value', 'form');
		
		$submit = $this->form->newInput( 'submit' );
		$submit->set( 'name', 'submit' );
		$submit->set( 'id', 'submit' );
		$submit->set( 'value', 'Save' );
	}
	
	/*
	 * Define the array to set the Meditation time options
	 */
	protected function durationTimeOptions()
	{
		$array = array();
		// 5 minute increments up to 2 hours
		for ( $i = 0; $i < 24; $i++ ) {
			$minutes = ($i + 1) * 5;
			$seconds = $minutes * 60;
			$array[] = [$minutes, $this->getTimeSelectorText( $minutes )];
		}
		// 15 minute increments from 2 hours to 4 hours
		for ( $i = 0; $i < 8; $i++ ) {
			$minutes = 120 + ($i + 1) * 15;
			$seconds = $minutes * 60;
			$array[] = [$minutes, $this->getTimeSelectorText( $minutes)];
		}
		
		return $array;
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
	 * Create a cancel link
	 */
	protected function cancelLink()
	{
		return '<p class="form-link-cancel"><a href="/journal">Cancel</a></p>';
	}
	
	/*
	 * Create a delete link
	 */
	protected function deleteLink()
	{
		return '<p class="form-link-delete"><a href="/journal/delete/' . $this->data['id'] . '">Delete Meditation Time</a></p>';
	}
}