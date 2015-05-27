<?php
namespace Src\Modules\Meditate\Models;

use Src\Includes\SuperClasses\Model;

class MeditateModel extends Model
{
	/*
	 * Look up the data
	 */
	public function run()
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
