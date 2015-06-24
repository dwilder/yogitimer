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
	 * Get the content
	 */
	public function getContent()
	{
		return $this->content;
	}
	
	/*
	 * Build the interface
	 */
	public function run()
	{
		$content = $this->getTitle();
		$content .= $this->getHelp();
		
		$this->form = new Form();
		$this->buildForm();
		$content .= $this->form->getHTML();
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
		$preparation = $this->form->newInput( 'select' );
		$preparation->setLabel( 'Preparation' );
		$preparation->set( 'name', 'preparation' );
		$preparation->set( 'id', 'preparation' );
		$preparation->setOptions( $this->preparationTimeOptions() );

		$meditation = $this->form->newInput( 'select' );
		$meditation->setLabel( 'Meditation' );
		$meditation->set( 'name', 'meditation' );
		$meditation->set( 'id', 'meditation' );
		$meditation->setOptions( $this->meditationTimeOptions() );

		$cooldown = $this->form->newInput( 'select' );
		$cooldown->setLabel( 'Cool Down' );
		$cooldown->set( 'name', 'cooldown' );
		$cooldown->set( 'id', 'cooldown' );
		$cooldown->setOptions( $this->cooldownTimeOptions() );
		
		$gong = $this->form->newInput( 'select' );
		$gong->setLabel( 'Gong' );
		$gong->set( 'name', 'gong' );
		$gong->set( 'id', 'gong' );
		$gong->setOptions( $this->gongOptions() );
		
		$begin = $this->form->newInput( 'submit' );
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
