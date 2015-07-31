<?php
namespace Src\Includes\Data;

use Src\Includes\Data\AbstractDataValue;

class MeditationPracticeName extends AbstractDataValue
{
	/*
	 * Store the validity
	 */
	private $valid = true;
	private $error = null;
    
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
        $value = strip_tags( $value );
        // Remove illegal characters
        $value = preg_replace('![^a-zA-Z0-9 ./-]!', '', $value);
        // Remove leading/trailing whitespace
        $value = trim( $value );
        // Get rid of leading non-alphanumerics
        $value = trim( $value, " ./-" );
        
        return $value;
    }
	
	/*
	 * Check if the name is valid
	 */
	public function isValid()
	{
		// Make sure it's not empty
		if ( ! $this->value || strlen( $this->value ) == 0 ) {
			$this->valid = false;
			$this->error = 'You must have a practice name.';
			return false;
		}
		
		// Must be less than 30 characters
		if ( strlen( $this->value ) > 80 ) {
			$this->valid = false;
			$this->error = 'Your practice name must be less than 80 characters.';
			return false;
		}
		
		// It's valid
		return true;
	}
	
	/*
	 * Return the value
	 */
	public function getValue()
	{
		return $this->value;
	}
	
	/*
	 * Return the error
	 */
	public function getError()
	{
		return $this->error;
	}
}