<?php
namespace Src\Includes\Data;

use Src\Includes\Data\AbstractDataValue;

class MeditationPracticeGoalTime extends AbstractDataValue
{
    /*
     * Set the value
     */
    public function __construct( $value = null )
    {
        $this->value = $this->sanitize($value);
    }
    
    /*
     * Strip illegal characters
     */
    protected function sanitize( $value )
    {
        if ( $value == null ) {
            return null;
        }
        // Remove illegal characters
        $value = preg_replace('![^0-9.]!', '', $value);
        // Remove leading/trailing whitespace
        $value = trim( $value );
        
        // Only accept whole numbers
        $dec = strpos( $value, '.' );
        if ( $dec != false ) {
            $value = substr( $value, 0, $dec );
        }
        
        if ( $value == 0 ) {
            return null;
        }
        
        return $value;
    }
	
	/*
	 * Return the value
	 */
	public function getValue()
	{
		return $this->value;
	}
}