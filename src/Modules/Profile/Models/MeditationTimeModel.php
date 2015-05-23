<?php
namespace Src\Modules\Profile\Models;

use Src\Includes\Module\Model;

class MeditationTimeModel extends Model
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
		$data = array(
			'total' => 0
		);
		$years = array(
			2010 => $this->dummyMonthData(),
			2011 => $this->dummyMonthData(),
			2012 => $this->dummyMonthData(),
			2013 => $this->dummyMonthData(),
			2014 => $this->dummyMonthData(),
			2015 => $this->dummyMonthData()
		);
		$yearTotals = array();
		foreach ( $years as $year => $months) {
			$yearTotals[$year] = $this->dummyYearly( $months );
			$data['total'] += $yearTotals[$year];
		}
		krsort( $yearTotals );
		$data = $data + $yearTotals;
		return $data;
	}
	
	private function dummyMonthData()
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
	protected function dummyYearly( $months )
	{
		$total = 0;
		foreach ( $months as $month => $days) {
			foreach ( $days as $d => $time ) {
				$total += $time;
			}
		}
		
		return $total;
	}
}
