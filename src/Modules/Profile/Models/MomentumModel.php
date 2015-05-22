<?php
namespace Src\Modules\Profile\Models;

use Src\Lib\Module\Model;

/*
 * Momentum represents the meditation requency
 *
 */
class MomentumModel extends Model
{	
	/*
	 * Set the data values
	 */
	protected function setData()
	{
		// Dummy values
		$data['momentum'] = 25;
		
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
