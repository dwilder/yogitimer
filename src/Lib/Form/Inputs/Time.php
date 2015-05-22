<?php
namespace Src\Lib\Form\Inputs;

use Src\Lib\Form\Inputs\AbstractInput;

class Time extends AbstractInput
{
	use LabelTrait;
	use InputTrait;
	
	/*
	 * Set the type
	 */
	protected $type = "time";
}