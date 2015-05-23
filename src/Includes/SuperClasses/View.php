<?php
namespace Src\Includes\SuperClasses;

abstract class View
{

	/*
	 * Store the title
	 */
	protected $title;
	
	/*
	 * Store the data
	 */
	protected $data = array();
	
	/*
	 * Store the form
	 */
	protected $form;
	
	/*
	 * Store the content
	 */
	protected $content;
	
	/*
	 * Set data from the model
	 */
	public function setData( array $data = array() )
	{
		$this->data = $data;
	}
	
	/*
	 * Get the content
	 */
	public function getContent()
	{
		$this->setContent();
		
		return $this->content;
	}
	
	/*
	 * Set the content
	 */
	abstract protected function setContent();
    
	/*
	 * Build the title
	 */
	protected function getTitle()
	{
		return "<h1>{$this->title}</h1>";
	}
}
