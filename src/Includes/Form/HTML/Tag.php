<?php
namespace Src\Includes\Form\HTML;

/*
 * Creates an HTML element to add to a form
 */
class Tag
{
	/*
	 * Store the element without angle brackets
	 */
	protected $tag;
	
	/*
	 * Store the content
	 */
	protected $content = null;
	
	/*
	 * Store html tag attribures
	 */
	protected $attributes = array();
	
	/*
	 * Constructor
	 */
	public function __construct( $tag, $content = null )
	{
		$this->tag = $tag;
		$this->content = $content;
	}
	
	/*
	 * Add attributes
	 */
	public function set( $property, $value )
	{
		$this->attributes[$property] = $value;
	}
	
	/*
	 * Return the HTML
	 */
	public function getHtml()
	{
		if ( $this->tag == 'img' ) {

			$img = '<img src="' . $this->content . '"';
			if ( !empty( $this->attributes ) ) {
				foreach ( $this->attributes as $k => $v ) {
					$img .= ' ' . $k . '="' . $v . '"';
				}
			}
			$img .= ' />';
		
			return $img;
			
		} else {
			
			$open = '<' . $this->tag;
			if ( !empty( $this->attributes ) ) {
				foreach ( $this->attributes as $k => $v ) {
					$open .= ' ' . $k . '="' . $v . '"';
				}
			}
			$open .= '>';
		
			$close = '</' . $this->tag . '>';
		
			return $open . $this->content . $close;
			
		}
	}
}
