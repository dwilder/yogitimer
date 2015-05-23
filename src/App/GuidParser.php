<?php
namespace Src\App;

class GuidParser
{
	/*
	 * Store the guid
	 */
	private $guid = null;
	
	/*
	 * Constructor sets the guid
	 */
	public function __construct()
	{
		$this->setGuid();
	}
	
	/*
	 * Set the guid
	 */
	private function setGuid()
	{
		if ( isset( $_GET['guid'] ) ) {
			$this->guid = strtolower( $_GET['guid'] );
		} elseif ( isset( $_POST['guid'] ) ) {
			$this->guid = strtolower( $_POST['guid'] );
		}
	}
	
	/*
	 * Get the guid
	 */
	public function getGuid()
	{
		return $this->guid;
	}
}
