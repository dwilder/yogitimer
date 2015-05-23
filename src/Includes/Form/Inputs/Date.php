<?php
namespace Src\Includes\Form\Inputs;

use Src\Includes\Form\Inputs\AbstractInput;

class Date extends AbstractInput
{
	use LabelTrait;
	use InputTrait;
	
	/*
	 * Set the type
	 */
	protected $type = "date";
}