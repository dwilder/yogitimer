<?php
namespace Src\Modules\Settings\Models;

use Src\Includes\Form\Form;

class ImagesModel
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
			'profile_image' => '/assets/img/profile_placeholder.jpg',
			'background_image' => 'assets/img/profile_background.jpg'
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