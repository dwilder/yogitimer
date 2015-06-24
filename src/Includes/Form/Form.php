<?php
namespace Src\Includes\Form;

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
	private $action = null;
	private $method = 'post';
	private $id = null;
	private $enctype = false;
	
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
     * Set enctype to true
     */
    public function enableFileUploading( $bool = true )
    {
        $this->enctype = $bool;
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
        $start .= ' class="group"';
        $start .= ' action="' . $this->action . '"';
		$start .= ' method="' . $this->method . '"';
		$start .= ( $this->enctype ) ? ' enctype="multipart/form-data"' : '';
		$start .= ">\n";
		
		$end = "</form>\n";
		
		$content = '';
		foreach ( $this->elements as $element ) {
			$content .= $element->getHtml();
		}
		
		return $start . $content . $end;
	}
}
