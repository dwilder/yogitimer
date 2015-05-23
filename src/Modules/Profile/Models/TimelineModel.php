<?php
namespace Src\Modules\Profile\Models;

use Src\Includes\SuperClasses\Model;

class TimelineModel extends Model
{	
	/*
	 * Set the data values
	 */
	protected function setData()
	{
		// Dummy values
		$data = $this->dummyData();
		
		$this->data = $data;
	}
    
    /*
     * Run
     */
    public function run()
    {
        $this->setData();
    }
	
	private function dummyData()
	{
		$data = array();
		$months = array(
			'January' => 31,
			'February' => 28,
			'March' => 31,
			'April' => 30,
			'May' => 31,
			'June' => 30,
			'July' => 31,
			'August' => 31,
			'September' => 30,
			'October' => 31,
			'November' => 30,
			'December' => 31
		);
		foreach ( $months as $m => $d ) {
			for ( $i = 1; $i <= $d; $i++ ) {
				$data[$m][$i] = $this->dummyTime();
			}
		}
		
		return $data;
	}
	private function dummyTime()
	{
		$maxTime = 120;
		$time = rand(0,120);
		
		return $time;
	}
	
}
