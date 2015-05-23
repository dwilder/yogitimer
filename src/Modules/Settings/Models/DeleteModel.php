<?php
namespace Src\Modules\Settings\Models;

use Src\Includes\Form\Form;

class DeleteModel
{	
	/*
	 * Store user data
	 */
	protected $data = array();
	
	/*
	 * Set the data
	 */
	public function setData()
	{
		$this->data = array();
	}
	
	/*
	 * Return the user data
	 */
	public function getData()
	{
		$this->setData();
		
		return $this->data;
	}
}