<?php
namespace Src\Lib\Form\Inputs;

use Src\Lib\Form\Inputs\AbstractInput;

class File extends AbstractInput
{
	use LabelTrait;
	use InputTrait;
	
	/*
	 * Set the type
	 */
	protected $type = "file";
}