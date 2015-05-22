<?php
namespace Src\Modules\Index\Models;

abstract class AbstractSubsectionModel
{
	/*
	 * Data Types
	 */
	protected $image;
	protected $content;
	
	/*
	 * Constructor
	 */
	public function __construct()
	{
		$this->setData();
	}
	
	/*
	 * Set default data
	 */
	public function setData() {}
	
	/*
	 * Return data
	 */
	public function get( $data ) {
		return $this->$data;
	}
}