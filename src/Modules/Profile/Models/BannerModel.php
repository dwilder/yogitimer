<?php
namespace Src\Modules\Profile\Models;

use Src\Modules\Profile\Models\AbstractProfileModel;
use Src\Includes\User\User;
use Src\Modules\Profile\Models\LevelModel;

class BannerModel extends AbstractProfileModel
{
    /*
     * Store the user level object
     */
    private $level;
    
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
        $this->data['profile'] = $user->getImage('profile');
        $this->data['banner'] = $user->getImage('banner');
        
        $this->setLevel();
	}
    
    /*
     * Set the user level
     */
    protected function setLevel()
    {
        $this->level = new LevelModel;
        $this->level->setTotalTime( $this->meditation_data_model->getTotalTime() );
        $this->data['level'] = $this->level->getLevel();
    }
    
}
