<?php
namespace Src\Includes\Form\Inputs;

use Src\Includes\Form\Inputs\AbstractInput;

class Hidden extends AbstractInput
{
	use LabelTrait;
	use InputTrait;
	
	/*
	 * Get the input
	 */
	public function getHtml()
	{
		return $this->buildInput();
	}
    
	/*
	 * Set the type
	 */
	protected $type = "hidden";
}