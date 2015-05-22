<?php
namespace Src\Modules\Settings\Models;

use Src\Lib\Form\Form;

class SettingsModel
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
		$this->data = array(
			'id' => 1,
			'username' => 'admin',
			'email' => 'admin@example.com'
		);
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