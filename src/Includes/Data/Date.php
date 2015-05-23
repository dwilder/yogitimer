<?php
namespace Src\Includes\Data;

class Date extends AbstractDataValue
{
    /*
     * Set the value
     */
    public function __construct( $value = null )
    {
        $this->value = $this->sanitize($value);
    }
    
    /*
     * Strip illegal characters and format correctly
     */
    protected function sanitize( $value )
    {
        // Remove illegal characters
        $value = preg_replace('![^0-9 ./-]!', '', $value);
        // Remove leading/trailing whitespace
        $value = trim( $value );
        // Get rid of leading non-digits
        $value = trim( $value, " ./-" );
        // Replace ./- with space
        $value = preg_replace('![./-]!', ' ', $value);
        // Remove double spaces
        $value = preg_replace('![ ]+!', ' ', $value);
        
        return $value;
    }
    
    /*
     * Check if it's a valid date
     */
    public function isValid()
    {
        if ( ! $this->value || ! strtotime( $this->getFormatted() ) ) {
            return false;
        }
        return true;
    }
    
    /*
     * Return a properly formatted date string
     */
    public function getFormatted()
    {
        return str_replace( ' ', '-', $this->value );
    }
}
