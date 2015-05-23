<?php
namespace Src\Modules\Meditate\Views;

use Src\Includes\Form\Form;

class MeditateView
{
	/*
	 * Store the data
	 */
	private $data;
	
	/*
	 * Store the form
	 */
	protected $Form;
	
	/*
	 * Set the data
	 */
	public function setData( $data )
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
	 * Build the interface
	 */
	public function setContent()
	{
		$content = $this->getTitle();
		$content .= $this->getHelp();
		
		$this->Form = new Form();
		$this->buildForm();
		$content .= $this->Form->getHTML();
		$content .= $this->getModal();
		
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
		$preparation = $this->Form->newInput( 'select' );
		$preparation->setLabel( 'Preparation' );
		$preparation->setOptions( $this->preparationTimeOptions() );

		$meditation = $this->Form->newInput( 'select' );
		$meditation->setLabel( 'Meditation' );
		$meditation->setOptions( $this->meditationTimeOptions() );

		$cooldown = $this->Form->newInput( 'select' );
		$cooldown->setLabel( 'Cool Down' );
		$cooldown->setOptions( $this->cooldownTimeOptions() );
		
		$gong = $this->Form->newInput( 'select' );
		$gong->setLabel( 'Gong' );
		$gong->setOptions( $this->gongOptions() );
		
		$begin = $this->Form->newInput( 'submit' );
		$begin->set( 'value', 'Begin' );
	}
	
	/*
	 * Define the array to set the Preparation time options
	 */
	protected function preparationTimeOptions()
	{
		return array(
			[null, 0],
			[30, '30 seconds'],
			[60, '1 minute'],
			[90, '90 seconds'],
			[120, '2 minutes']
		);
	}
	
	/*
	 * Define the array to set the Meditation time options
	 */
	protected function meditationTimeOptions()
	{
		$array = array();
		// 5 minute increments up to 2 hours
		for ( $i = 0; $i < 24; $i++ ) {
			$minutes = ($i + 1) * 5;
			$seconds = $minutes * 60;
			$array[] = [$seconds, $this->getTimeSelectorText( $minutes )];
		}
		// 15 minute increments from 2 hours to 4 hours
		for ( $i = 0; $i < 8; $i++ ) {
			$minutes = 120 + ($i + 1) * 15;
			$seconds = $minutes * 60;
			$array[] = [$seconds, $this->getTimeSelectorText( $minutes)];
		}
		
		return $array;
	}
	
	/*
	 * Define the array to set the cool down time options
	 */
	protected function cooldownTimeOptions()
	{
		$array = array();
		for ( $i = 0; $i < 10; $i++ ) {
			$minutes = $i +1;
			$seconds = $minutes * 60;
			$array[] = [$seconds, $this->getTimeSelectorText( $minutes )];
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
			['all', 'All Sections'],
			['meditation', 'Start and End of Meditation'],
			['none', 'None']
		);
		
		return $array;
	}
	
	/*
	 * Create a modal layer to display the timer, JS like
	 */
	protected function getModal()
	{
		$start = '<div id="modal" class="modal" style="display:none;">';
		$end = '</div>';
		
		$timer = '<div id="modal-timer" class="modal-timer"></div>';
		
		$link = '<p class="modal-endlink"><a href="">End</a></p>';
		
		return $start . $timer . $link . $end;
	}
}
