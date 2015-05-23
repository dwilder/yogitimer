<?php
namespace Src\Includes\Form\Inputs;

//use Src\Includes\Form\Inputs\AbstractInput;
//use Src\Includes\Form\Inputs\LabelTrait;

class Select extends AbstractInput
{
	use LabelTrait;
	
	/*
	 * Store options
	 */
	protected $options = array();
	
	/*
	 * Set the options
	 */
	public function setOptions( array $options )
	{
		$this->options = $options;
	}
	
	/*
	 * Build the input
	 */
	protected function buildInput() {
		
		$select = '<select';
		$select .= ( $this->name ) ? ' name="' . $this->name . '"' : '';
		$select .= ( $this->id ) ? ' id="' . $this->id . '"' : '';
		$select .= ( $this->class ) ? ' class="' . $this->class . '"' : '';
		$select .= ">\n";
		
		$select .= $this->getOptions();
		
		$select .= "</select>\n";
		
		return $select;
	}
	
	/*
	 * Build options
	 */
	private function getOptions()
	{
		$options = '';
		if ( !empty( $this->options ) ) {
			foreach ( $this->options as $option ) {
				$options .= '<option';
				$options .= ' value="' . $option[0] . '"';
				$options .= ( $this->value == $option[0] ) ? ' selected="selected"' : '';
				$options .= '>';
				$options .= $option[1];
				$options .= "</option>\n";
			}
		}
		return $options;
	}
}