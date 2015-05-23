<?php
namespace Src\Includes\Form\Inputs;

use Src\Includes\Form\Inputs\AbstractInput;
use Src\Includes\Form\Inputs\LabelTrait;
use Src\Includes\Form\Inputs\InputTrait;

class Email extends AbstractInput
{
	use LabelTrait;
	use InputTrait;
	
	/*
	 * Set the type
	 */
	protected $type = "email";
}