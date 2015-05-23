<?php
namespace Src\Includes\Form\Inputs;

use Src\Includes\Form\Inputs\InputInterface;

abstract class AbstractInput implements InputInterface
{	
	/*
	 * Validation rules
	 */
	protected $rules = array();
	
	/*
	 * Function to set attributes
	 */
	public function set( $attr, $value = null )
	{
		$this->$attr = $value;
	}
	
	/*
	 * Set a rule
	 */
	public function setRule( $rule ) {
		$this->rules[] = $rule;
	}
	
	/*
	 * Get the input
	 */
	public function getHtml()
	{
		return $this->buildHTML();
	}
	
	/*
	 * Build the HTML
	 */
	protected function buildHTML()
	{
		$start = '<div class="form-input">';
		$end = '</div>';
		$label = $this->getLabel();
		$input = $this->buildInput();
		
		return $start . $label . $input . $end;
	}
}
