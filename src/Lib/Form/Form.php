<?php
namespace Src\Lib\Form;

/*
 * Class for creating forms
 */

class Form
{
	/*
	 * Store the form elements
	 */
	protected $elements = array();
	
	/*
	 * Store the form attributes
	 */
	private $action;
	private $method;
	private $id;
	
	/*
	 * Store the factories
	 */
	private $InputFactory;
	private $HtmlFactory;
	
	/*
	 * Store the validator
	 */
	private $Validator;
	
	/*
	 * Constructor
	 */
	public function __construct()
	{
		$this->method = 'post';
		$this->InputFactory = new InputFactory;
		$this->HtmlFactory = new HtmlFactory;
	}
	
	/*
	 * Pass input requests to the input factory
	 */
	public function newInput( $type )
	{
		$input = $this->InputFactory->newInput( $type );
		$this->elements[] = $input;
		return $input;
	}
	
	/*
	 * Pass new tag requests to the html factory
	 */
	public function newHtml( $tag, $content = null )
	{
		$element = $this->HtmlFactory->newHtml( $tag, $content );
		$this->elements[] = $element;
		return $element;
	}
	
	/*
	 * Get the HTML
	 */
	public function getHTML()
	{
		$start = '
			<form';
		$start .= ( $this->id ) ? ' id="' . $this->id . '"' : '';
		$start .= ( $this->action ) ? ' action="' . $this->action . '"' : '';
		$start .= ( $this->method ) ? ' method="' . $this->method . '"' : '';
		$start .= ">\n";
		
		$end = "</form>\n";
		
		$content = '';
		foreach ( $this->elements as $element ) {
			$content .= $element->getHtml();
		}
		
		return $start . $content . $end;
	}
}
