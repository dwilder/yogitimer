<?php
namespace Src\Modules\Content;

use Src\Includes\SuperClasses\UIController;
use Src\Modules\Content\ContentFactory;
use Src\Modules\Content\NotFound;

/*
 * Controller class for content pages.
 */

class Controller extends UIController
{
	/*
	 * Store the factory
	 */
	private $ContentFactory;
	
	/*
	 * Constructor
	 */
	public function __construct()
	{
		$this->ContentFactory = new ContentFactory;
	}
    
    /*
     * Set the class name for the model and view
     */
    protected function setClass() {}
    protected function setModel() {}
    protected function setView() {}
        
	/*
	 * Return the requested data
	 */
	public function respond( )
	{
		$content = $this->ContentFactory->getContent( $this->request['guid'] );
		
		if ( !$content ) {
			$content = (new NotFound)->getContent();
		}

		$this->setTemplate();
		$this->template->setGuid( $this->request['guid'] );
		$this->template->setContent( $content );
		echo $this->template->request();
	}
}
