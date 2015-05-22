<?php
namespace Src\Modules\Profile\Views;

abstract class AbstractProfileDataView
{
	/*
	 * Define a size for the display area
	 */
	protected $viewSize = 'small'; // or large
	
	/*
	 * Store the title and content
	 */
	protected $title;
	protected $content;
	
	/*
	 * Store the data
	 */
	protected $data;
	
	/*
	 *
	 */
	public function setData( $data )
	{
		$this->data = $data;
	}
	
	/*
	 * Build the section
	 */
	public function getHtml()
	{
		$start = '<div';
		$start .= ' id="profile-' . str_replace( ' ', '' , strtolower( $this->title ) ) . '"';
		$start .= ' class="profile-data-' . $this->viewSize . '">';
		
		$end = '</div>';
		
		$title = '<h2>' . $this->title . '</h2>';
		
		$this->buildContent();
		
		return $start . $title . $this->content . $end;
	}
	
	/*
	 * Build the HTML content for display
	 */
	abstract protected function buildContent();
}
