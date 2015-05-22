<?php
namespace Src\Lib\UIElements;

class LinkButton
{
	/*
	 * Store the element
	 */
	private $html;
	
	/*
	 * Build a link button
	 */
	public function __construct( $action, $text, $class = null )
	{
		$html = '<a href="' . $action . '" class="link-button';
		$html .= ( $class ) ? ' ' . $class : '';
		$html .= '">';
		$html .= $text;
		$html .= '</a>';
		
		$this->html = $html;
	}
	
	/*
	 * Get the html
	 */
	public function getHtml()
	{
		return $this->html;
	}
	
	/*
	 * Get the html
	 */
	public function __toString()
	{
		return $this->html;
	}
}
