<?php
namespace Src\Includes\Form\Inputs;

/*
 * A trait to define input labelling
 */

trait LabelTrait
{
	/*
	 * Create a label for an input
	 */
	protected $label;
	public function setLabel( $label )
	{
		$this->label = $label;
	}
	protected function getLabel()
	{
		if ( $this->label ) {
			$label = '<label';
			$label .= ( $this->id ) ? ' for="' . $this->id . '"' : '';
			$label .= '>' . $this->label . '</label>';
			
			return $label;
		}
	}
}