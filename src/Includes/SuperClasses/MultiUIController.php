<?php
namespace Src\Includes\SuperClasses;

use Src\Includes\SuperClasses\UIController;

/*
 * Abstract class for module UI controllers
 */
abstract class MultiUIController extends UIController
{   
	/*
	 * Process the request
	 */
	public function respond()
	{
		$this->setTemplate();
		$this->template->setGuid( $this->request['guid'] );
		$this->template->setContent( $this->view->getContent() );
	
		echo $this->template->request();	
	}	
}