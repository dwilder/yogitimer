<?php
namespace Src\Lib\Form\Inputs;

use Src\Lib\Form\Inputs\AbstractInput;
use Src\Lib\Form\Inputs\LabelTrait;
use Src\Lib\Form\Inputs\InputTrait;

class Tel extends AbstractInput
{
	use LabelTrait;
	use InputTrait;
	
	/*
	 * Set the type
	 */
	protected $type = "tel";
}
