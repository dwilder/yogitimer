<?php
namespace Src\Modules\Journal\Helpers;

/*
 * Dummy data for testing
 */

trait tDummyData
{
	/*
	 * Generate dummy data
	 */
	protected function dummyData()
	{
		// A full day in seconds
		$day = 24 * 60 * 60;
		
		// Current timestamp
		$now = time();
		
		// Generate data for a year
		$days = 365;
		
		
		$data = array();
		for ( $i = 1; $i < $days; $i++ ) {
			// 50% chance of a meditation
			if ( rand(0, 1) == 1 ) {
				$data[] = array(
					'id' => $i,
					'start_time' => ( $now - $i*$day),
					'duration' => ( rand(1, 12) * 5 )
				);
			}
		}
		
		return $data;
	}
}
