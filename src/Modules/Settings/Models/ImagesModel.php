<?php
namespace Src\Modules\Settings\Models;

use Src\Includes\SuperClasses\Model;

class ImagesModel extends Model
{	
	/*
	 * Set the data
	 */
	public function run()
	{
		$this->data = array(
			'profile_image' => '/assets/img/profile_placeholder.jpg',
			'background_image' => '/assets/img/profile_background.jpg'
		);
	}
}