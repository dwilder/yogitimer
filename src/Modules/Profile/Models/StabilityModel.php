<?php
namespace Src\Modules\Profile\Models;

use Src\Includes\Module\Model;

class StabilityModel extends Model
{	
	/*
	 * Set the data values
	 */
	protected function setData()
	{
		// Dummy values
		$data['stability'] = 25;
		
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
