<?php
namespace Src\Includes\Form\Inputs;

use Src\Includes\Form\Inputs\AbstractInput;

class Textarea extends AbstractInput
{
	use LabelTrait;
	use InputTrait;
	
	/*
	 * Build the input
	 */
	protected function buildInput()
	{
        $html = '';
        
		$html .= ( $this->error ) ? $this->getError() : '';

		$html .= '<textarea';

		$html .= ( $this->name ) ? ' name="' . $this->name . '"' : '';
		$html .= ( $this->id ) ? ' id="' . $this->id . '"' : '';
		$html .= ( $this->class ) ? ' class="' . $this->class . '"' : '';
		$html .= ( $this->placeholder ) ? ' placeholder="' . $this->placeholder . '"' : '';
		$html .= ">";
        
		$html .= ( $this->value ) ? $this->value : '';
        
        $html .= '</textarea>';
		
		$html .= ( $this->help ) ? $this->getHelp() : '';
		
		return $html;
	}
}