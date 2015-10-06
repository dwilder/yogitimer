<?php
namespace Src\Includes\Data;

class DateTime extends AbstractDataValue
{
    /*
     * Constructor
     */
    public function __construct( $value = null )
    {
        $this->value = $value;
    }
    
    /*
     * Return the date
     */
    public function getDate()
    {
        if ( $this->value != null ) {
            $date = strtotime( $this->value );
            return date( 'd m Y', $date );
        }
        return null;
    }
    
    /*
     * Return long date format
     */
    public function getLongDate()
    {
        if ( $this->value != null ) {
            $date = strtotime( $this->value );
            return date( 'l, F j, Y', $date );
        }
        return null;
    }
    
    /*
     * Return the time portion
     */
    public function getTime()
    {
        if ( $this->value != null ) {
            $time = strtotime( $this->value );
            $time = date( 'g:i a', $time );
            return $time;
        }
        return null;
    }
    
}
