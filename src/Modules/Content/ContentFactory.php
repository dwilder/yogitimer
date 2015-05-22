<?php
namespace Src\Modules\Content;

use Src\Modules\Content\Pages\AboutPage;

/*
 * ContentFactory class determines the page to display
 */
class ContentFactory
{
	/*
	 * Store the page
	 */
	private $Page;
	
	/*
	 * Get the content
	 */
	public function getContent( $guid )
	{
		$class = 'Src\Modules\Content\Pages\\' . ucfirst( $guid ) . 'Page';
		
		if ( class_exists( $class ) ) {
			$this->Page = new $class;
			return $this->Page->getContent();
		}
		
		return false;
	}
}