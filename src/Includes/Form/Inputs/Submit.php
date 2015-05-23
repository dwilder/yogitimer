<?php
namespace Src\Lib\Form\Inputs;

use Src\Lib\Form\Inputs\AbstractInput;
use Src\Lib\Form\Inputs\InputTrait;

class Submit extends AbstractInput
{
	use InputTrait;
	
	/*
	 * Set the type
	 */
	protected $type = "submit";
	/*
	 * Build the input
	 */
	protected function buildHTML()
	{
		$input = $this->buildInput();
		
		return '<div class="form-submit">' . $input . '</div>';
	}
}