<?php
namespace Src\Lib\Form\Inputs;

/*
 * A trait to define input fields
 */

trait InputTrait
{	
	/*
	 * Input attributes
	 */
	protected $name;
	protected $id;
	protected $class;
	protected $placeholder;
	protected $value;
	
	/*
	 * Help text, error
	 */
	protected $help = null;
	protected $error = null;
	
	/*
	 * Help text methods
	 */
	public function setHelp( $html )
	{
		$this->help = $html;
	}
	protected function getHelp()
	{
		return '<span class="form-input-help">' . $this->help . '</span>';
	}
	
	/*
	 * Error text methods
	 */
	public function setError( $error )
	{
		$this->error = $error;
	}
	protected function getError()
	{
		return '<span class="form-input-error">' . $this->error . '</span>';
	}
	
	/*
	 * Build the input
	 */
	protected function buildInput()
	{
		$html = '<input type="' . $this->type . '"';

		$html .= ( $this->name ) ? ' name="' . $this->name . '"' : '';
		$html .= ( $this->id ) ? ' id="' . $this->id . '"' : '';
		$html .= ( $this->class ) ? ' class="' . $this->class . '"' : '';
		$html .= ( $this->placeholder ) ? ' placeholder="' . $this->placeholder . '"' : '';
		$html .= ( $this->value ) ? ' value="' . $this->value . '"' : '';
		
		$html .= " />";
		
		$html .= ( $this->error ) ? $this->getError() : '';
		$html .= ( $this->help ) ? $this->getHelp() : '';
		
		return $html;
	}
}