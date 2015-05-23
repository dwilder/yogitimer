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
	 * Return the requested data
	 */
	public function request( )
	{
		$content = $this->ContentFactory->getContent( $this->guid );
		
		if ( !$content ) {
			$content = (new NotFound)->getContent();
		}

		$this->setTemplate();
		$this->template->setGuid( $this->guid );
		$this->template->setContent( $content );
		return $this->template->request();
	}
}
