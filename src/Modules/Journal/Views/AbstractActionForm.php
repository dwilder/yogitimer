<?php
namespace Src\Modules\Journal\Views;

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
            $content .= '<p class="form-success">Your meditation has been updated.</p>';
        }
		
        if ( isset( $this->data['error']['form'] ) ) {
            $content .= '<p class="form-error">' . $this->data['error']['form'] . '</p>';
        }
		$this->form = new Form;
		$this->buildForm();
		$content .= $this->form->getHtml();
		
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
        $this->setPractices();
        
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
        
        $cancel = $this->form->newHtml( 'p', '<a href="/journal">Cancel</a>' );
        $cancel->set( 'class', 'form-link-cancel' );
	}
    
    /*
     * Set the practices selection
     */
    protected function setPractices()
    {
        $practices_obj = $this->data['practices'];
        $practices = $practices_obj->get();
    
        if ( count( $practices ) == 1 ) {
            // Create a hidden input with value 0
            $practice = $this->form->newInput( 'hidden' );
            $practice->set( 'name', 'practice' );
            $practice->set( 'value', '0' );
        }
        else {
            // Create a select box with practice ids and names
            $options = array();
            foreach ( $practices as $practice ) {
                $options[] = [ $practice['id'], $practice['name'] ];
            }
            $practice = $this->form->newInput( 'select' );
    		$practice->setLabel( 'Practice' );
    		$practice->set( 'name', 'practice' );
    		$practice->set( 'id', 'practice' );
    		$practice->set( 'value', $this->data['practice'] );
    		$practice->setOptions( $options );
        }
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