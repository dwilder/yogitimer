<?php
namespace Src\Includes\Form\Inputs;

use Src\Includes\Form\Inputs\AbstractInput;
use Src\Includes\Form\Inputs\LabelTrait;
use Src\Includes\Form\Inputs\InputTrait;

class Url extends AbstractInput
{
	use LabelTrait;
	use InputTrait;
	
	/*
	 * Set the type
	 */
	protected $type = "url";
}
