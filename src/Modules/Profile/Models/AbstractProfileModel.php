<?php
namespace Src\Modules\Profile\Models;

class AbstractProfileModel
{
	/*
	 * Store the values
	 */
	protected $data = array();
    
    /*
     * Store the meditation data model
     */
    protected $meditation_data_model;
    
    /*
     * Set the meditation data model
     */
    public function setMeditationDataModel( $model )
    {
        $this->meditation_data_model = $model;
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
	protected function run() {}
}