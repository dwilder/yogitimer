<?php
namespace Src\Includes\Form\Inputs;

/*
 * Interface for inputs
 */

interface InputInterface
{	
	/*
	 * Set validation rules
	 */
	public function setRule( $rule );
		
	/*
	 * Get the input
	 */
	public function getHtml();
	
}