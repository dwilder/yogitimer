<?php
namespace Src\Modules\Profile\Models;
	
class AbstractProfileModel
{
	/*
	 * Store the values
	 */
	protected $data = array();
	
	/*
	 * Constructor
	 */
	public function __construct()
	{
		$this->setData();
	}
	
	/*
	 * Return the values
	 */
	public function getData()
	{
		return $this->data;
	}
	
	/*
	 * Set the data values
	 */
	protected function setData() {}
}