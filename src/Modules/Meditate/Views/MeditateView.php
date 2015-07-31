<?php
namespace Src\Modules\Meditate\Views;

use Src\Includes\Form\Form;
use Src\Includes\SuperClasses\View;

class MeditateView extends View
{	
	/*
	 * Store the form
	 */
	protected $form;
	
	/*
	 * Build the interface
	 */
	public function run()
	{
		$content = $this->getTitle();
		$content .= $this->getHelp();
        
        $content .= $this->getSaveMessage();
		
		$this->form = new Form();
		$this->buildForm();
		$content .= $this->form->getHTML();
		//$content .= $this->getModal();
		
		$this->content = $content;
		return $content;
	}
	
	/*
	 * Get the title
	 */
	protected function getTitle()
	{
		return '<h1>Meditation Timer</h1>';
	}
	
	/*
	 * Get the write up
	 */
	protected function getHelp()
	{
		$html = '<p>';
		$html .= 'Set your preparation, meditation, and cool down times. Choose your gong settings. Then begin.';
		$html .= '</p>';
		
		return $html;
	}
	
	/*
	 * Create the form
	 */
	protected function buildForm()
	{
		/*$preparation = $this->form->newInput( 'select' );
		$preparation->setLabel( 'Preparation' );
		$preparation->set( 'name', 'preparation' );
		$preparation->set( 'id', 'preparation' );
		$preparation->set( 'value', $this->data['preparation'] );
		$preparation->setOptions( $this->preparationTimeOptions() );
        */
        $i = 0;
        foreach ( $this->data['sections'] as $array ) {
            $section[$i]['name'] = $this->form->newInput( 'hidden' );
            $section[$i]['name']->set( 'name', "sections[$i]['name']" );
            $section[$i]['name']->set( 'id', "sections[$i]['name']" );
            $section[$i]['name']->set( 'value', $array['name'] );
            
    		$section[$i]['time'] = $this->form->newInput( 'select' );
    		$section[$i]['time']->setLabel( $array['name'] );
    		$section[$i]['time']->set( 'name', "sections[$i]['time']" );
    		$section[$i]['time']->set( 'id', "sections[$i]['time']" );
    		$section[$i]['time']->set( 'value', $array['time'] );
            
            switch ( $array['times'] ) {
                case 'short':
            		$section[$i]['time']->setOptions( $this->getTimeOptions() );
                    break;
                case 'medium':
            		$section[$i]['time']->setOptions( $this->getTimeOptions( 0, 10 ) );
                    break;
                case 'long':
            		$section[$i]['time']->setOptions( $this->getLongTimeOptions() );
                    break;
            }
            
            $i++;
        }
        
        /*
		$meditation = $this->form->newInput( 'select' );
		$meditation->setLabel( 'Meditation' );
		$meditation->set( 'name', 'meditation' );
		$meditation->set( 'id', 'meditation' );
		$meditation->setOptions( $this->meditationTimeOptions() );
        
        
		$cooldown = $this->form->newInput( 'select' );
		$cooldown->setLabel( 'Cool Down' );
		$cooldown->set( 'name', 'cooldown' );
		$cooldown->set( 'id', 'cooldown' );
		$cooldown->set( 'value', $this->data['cooldown'] );
		$cooldown->setOptions( $this->cooldownTimeOptions() );
		*/
        
		$gong = $this->form->newInput( 'select' );
		$gong->setLabel( 'Gong' );
		$gong->set( 'name', 'gong' );
		$gong->set( 'id', 'gong' );
		$gong->set( 'value', $this->data['gong'] );
		$gong->setOptions( $this->gongOptions() );
		
		$begin = $this->form->newInput( 'submit' );
		$begin->set( 'name', 'submit' );
		$begin->set( 'id', 'submit' );
		$begin->set( 'value', 'Begin' );
	}
	
	/*
	 * Define the array to set the cool down time options
	 */
	protected function getTimeOptions( $start = 0, $end = 5, $increment = 1 )
	{
        if ( $start == 0 ) {
    		$array = array(
    		    [null, 0]
    		);
        }
        
		for ( $i = $increment; $i <= $end; $i += $increment ) {
			$minutes = $i;
			$array[] = [$minutes, $this->getTimeSelectorText( $minutes )];
		}
		
		return $array;
	}
    
	/*
	 * Define the array to set the Meditation time options
	 */
	protected function getLongTimeOptions()
	{
		$array = array();
		// 5 minute increments up to 2 hours
		for ( $i = 0; $i < 24; $i++ ) {
			$minutes = ($i + 1) * 5;
			//$seconds = $minutes * 60;
			$array[] = [$minutes, $this->getTimeSelectorText( $minutes )];
		}
		// 15 minute increments from 2 hours to 4 hours
		for ( $i = 0; $i < 8; $i++ ) {
			$minutes = 120 + ($i + 1) * 15;
			//$seconds = $minutes * 60;
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
	 * Define an array to set the gong options
	 */
	protected function gongOptions()
	{
		$array = array(
			['', 'None'],
			['all', 'All Sections'],
			['meditation', 'Start and End of Meditation']
		);
		
		return $array;
	}
    
    /*
     * Add a "saved" message indicator
     */
    protected function getSaveMessage()
    {
        if ( $this->data['saved'] ) {
            $html = '<p class="form-success" id="meditate-message-saved">Your meditation has been saved.</p>';
            return $html;
        }
        return '';
    }
}
