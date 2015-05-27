<?php
namespace Src\Includes\Data;

/*
 * Username class
 *
 * Holds username rules
 */

class Email
{
	use DatabaseValueTrait;
	
	/*
	 * Store the value
	 */
	private $value = null;
	
	/*
	 * Store the validity
	 */
	private $valid = true;
	private $error = null;
	
	/*
	 * Constructor
	 */
	public function __construct( $value = null )
	{
		$this->value = trim( $value );
	}
    
    /*
     * Set the value
     */
    public function setValue( $value )
    {
        $this->value = trim( $value );
    }
	
	/*
	 * Test the value
	 */
	public function test()
	{
		// Check if it passes email validation rules
		if ( !$this->isValid() ) {
			return false;
		}

		// Make sure it isn't already in the database
		if ( !$this->isUnique( 'users', 'email', $this->value ) ) {
			$this->valid = false;
			$this->error = 'This email is already registered. Please try another.';
			return false;
		}
		
		// It's OK
		return true;
	}
	
	/*
	 * Check if the name is valid
	 */
	public function isValid()
	{
		// Make sure it's not empty
		if ( !$this->value ) {
			$this->valid = false;
			$this->error = 'You must provide an email address.';
			return false;
		}
		
		// Can contain lowercase letters, numbers, underscore, hyphen, or period
		if ( !filter_var( $this->value, FILTER_VALIDATE_EMAIL ) ) {
			$this->valid = false;
			$this->error = 'Please provide a valid email address.';
			return false;
		}
		
		// Must be less than 60 characters
		if ( strlen( $this->value ) > 60 ) {
			$this->valid = false;
			$this->error = 'Your email address must be less than 60 characters.';
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