<?php
namespace Src\Modules\Meditate\Models;

class MeditateModel
{
	/*
	 * Store meditation set up values
	 */
	private $data = array();
	
	/*
	 * Return data
	 * Look up values for the last saved meditation and load them.
	 */
	public function getData()
	{
		$this->setData;
		
		return $this->data;
	}
	
	/*
	 * Look up the data
	 */
	private function setData()
	{
		//$raw = $this->lookupData();
		$data = $this->dummyData();
		
		$this->data = $data;
	}
	private function dummyData()
	{
		$data = array(
			'preparation' => 30,
			'meditation' => 5,
			'cooldown' => null,
			'gong' => true
		);
		
		return $data;
	}
}
