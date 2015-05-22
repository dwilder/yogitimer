<?php
namespace Src\Modules\Profile\Models;

class DummyMomentum extends AbstractProfileModel
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
}
