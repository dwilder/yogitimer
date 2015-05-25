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
        $this->setModuleName();
		$this->setModel();
		$this->setView();
		
		$this->setTemplate();
		$this->template->setGuid( $this->guid );
		$this->template->setContent( $this->view->getContent() );
	
		return $this->template->request();	
	}	
}