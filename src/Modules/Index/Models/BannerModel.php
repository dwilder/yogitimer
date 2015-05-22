<?php
namespace Src\Modules\Index\Models;

class BannerModel
{
	/*
	 * Store data
	 */
	private $image;
	private $title;
	private $content;
	private $action = array(
		'text' => null,
		'guid' => null
	);
	
	/*
	 * Assign values
	 */
	public function __construct()
	{
		$this->image = 'indexBannerImage.jpg';
		$this->title = "Meditation Timer and Journal";
		$this->content = "meditate.io is a simple meditation timer and journal.";
		$this->action = array(
			'text' => 'Meditate',
			'guid' => 'meditate'
		);
	}
	
	/*
	 * Get values
	 */
	public function get( $data )
	{
		return $this->$data;
	}
}