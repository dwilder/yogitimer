<?php
namespace Src\Modules\Profile\Models;

use Src\Includes\SuperClasses\Model;
use Src\Includes\User\User;


class BannerModel extends Model
{
    /*
     * Run
     */
    public function run()
    {
        $this->setData();
    }
    
	/*
	 * Set the data values
	 */
	protected function setData()
	{
		$user = User::getInstance();
        
        $this->data['username'] = $user->get('username');
        $this->data['level'] = $user->get('level');
        $this->data['profile'] = $user->getImage('profile');
        $this->data['banner'] = $user->getImage('banner');
	}
}
