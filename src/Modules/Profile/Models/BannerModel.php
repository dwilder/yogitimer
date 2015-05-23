<?php
namespace Src\Modules\Profile\Models;

use Src\Includes\Module\Model;

class BannerModel extends Model
{
	/*
	 * Set the data values
	 */
	protected function setData()
	{
		// Dummy values
		$data['username'] = 'username';
		$data['level'] = 'beginner';
		$data['profile'] = '/assets/img/profile-image.jpg';
		$data['background'] = '/assets/img/profile-background.jpg';
		
		$this->data = $data;
	}
    
    /*
     * Run
     */
    public function run()
    {
        $this->setData();
    }
}
