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
        // Remove leading/trailing whitespace
        $value = strtolower( trim( $value ) );
        
        if ( $value == 'today' || $value == 't' ) {
            return $this->set();
        }
        else if ( $value == 'yesterday' || $value == 'y' ) {
            return $this->set(1);
        }
        // Remove illegal characters
        $value = preg_replace('![^0-9 ./-]!', '', $value);
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
    
    /*
     * Set the current date
     */
    protected function set( $offset = 0 )
    {
        if ( ! $this->value ) {
            if ( $offset > 0 ) {
                return $this->value = date('d m Y', time() - $offset * 24 * 60 * 60 );
            }
            else {
                return $this->value = date( 'd m Y' );
            }
        }
    }
}
