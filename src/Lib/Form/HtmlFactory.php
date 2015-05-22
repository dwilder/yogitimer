<?php
namespace Src\Lib\Form;

use Src\Lib\Form\HTML\Tag;

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
		
		$class = 'Src\Lib\Form\HTML\Tag' ;
		$object = new $class( $tag, $content );
		return $object;
	}
}