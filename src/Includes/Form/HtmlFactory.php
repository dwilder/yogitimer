<?php
namespace Src\Includes\Form;

use Src\Includes\Form\HTML\Tag;

/*
 * Creates form inputs and html elements
 */

class HtmlFactory
{
	/*
	 * Track elements
	 */
	private $count = 0;
	
	/*
	 * Return an element
	 */
	public function newHtml( $tag, $content = null )
	{
		
		$class = 'Src\Includes\Form\HTML\Tag' ;
		$object = new $class( $tag, $content );
		return $object;
	}
}