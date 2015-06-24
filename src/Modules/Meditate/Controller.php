<?php
namespace Src\Modules\Meditate;

use Src\Includes\SuperClasses\UIController;
use Src\Modules\Meditate\Models\MeditateModel;
use Src\Modules\Meditate\Views\MeditateView;

/*
 * Controller class for the meditation section.
 *
 * - Meditation Form
 * - Meditation Timer
 * - Autolog Meditation Time
 * - Suggest login to autolog meditation time
 */

class Controller extends UIController
{
	/*
	 * Set the content
	 */
	public function setClass()
	{
		$this->class = 'Meditate';
	}
	
	/*
	 * Return the request
	 */
	public function respond()
	{
		$this->template->setGuid( $this->request['guid'] );
		$this->template->setTitle( 'Meditation Timer' );
        $this->template->setScript( 'meditation_timer.js' );
		$this->template->setContent( $this->view->getContent() );
		
		echo $this->template->request();	
	}
}