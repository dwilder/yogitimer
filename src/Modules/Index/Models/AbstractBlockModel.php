<?php
namespace Src\Modules\Index\Models;

abstract class AbstractBlockModel
{
	/*
	 * Data Types
	 */
	protected $title;
	protected $action = array(
		'text' => null,
		'guid' => null
	);
	
	/*
	 * Subsections
	 */
	protected $subsections = array();
	
	/*
	 * Constructor
	 */
	public function __construct()
	{
		$this->setData();
		$this->setSubsections();
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
	
	/*
	 * Set subsections
	 */
	public function setSubsections() {}
		
	/*
	 * Return subsection data as an array
	 */
	public function getSubsectionData()
	{
		$data = array();
		
		if ( !empty( $this->subsections ) ) {
			foreach ( $this->subsections as $section ) {
				$data[] = array(
					'image' => $section->get('image'),
					'content' => $section->get('content')
				);
				
			}
		}
		
		return $data;
	}
}