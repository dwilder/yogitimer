<?php
namespace Src\Lib\Data;

/*
 * Username class
 *
 * Holds username rules
 */

class Username
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
		$this->value = trim($value);
	}
	
	/*
	 * Test the value
	 */
	public function test()
	{
		// Check if it passes username character rules
		if ( ! $this->isValid() ) {
			return false;
		}

		// Make sure it isn't already in the database
		if ( ! $this->isUnique( 'users', 'username', $this->value ) ) {
			$this->valid = false;
			$this->error = 'This username is taken. Please try another.';
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
			$this->error = 'You must have a username.';
			return false;
		}
		
		// Can contain lowercase letters, numbers, underscore, hyphen, or period
		if ( !preg_match( '/^[a-z0-9._-]{1,}$/', $this->value ) ) {
			$this->valid = false;
			$this->error = 'Your username can contain lowercase letters, numbers, period, hyphen and underscore.';
			return false;
		}
		
		// Must be less than 30 characters
		if ( strlen( $this->value ) > 30 ) {
			$this->valid = false;
			$this->error = 'Your username must be less than 30 characters.';
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