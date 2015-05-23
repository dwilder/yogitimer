<?php
namespace Src\Lib\Data;

class Time extends AbstractDataValue
{
    /*
     * Store hours, minutes, meridiem
     */
    private $hours;
    private $minutes;
    private $meridiem;
    
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
        $value = preg_replace('![^0-9 :apm]!i', '', $value);
        
        // Get the hours value
        list( $hours, $remainder ) = explode( ':', $value, 2 );
        
        // Get the am or pm value
        $this->setMeridiem( $value );
        $this->setHours( $hours );
        $this->setMinutes( $remainder );
        
        
        return $this->hours . ':' . $this->minutes . ' ' . $this->meridiem;
    }
    
    /*
     * Correctly format the hours value
     */
    private function setHours( $hours )
    {
        $default = '12';
        
        if ( ! $hours ) {
            $this->hours = $default;
            return;
        }
        
        $hours = preg_replace('![^0-9]!', '', $hours);
        
        // Make sure it's a non-zero value
        if ( $hours == 0 ) {
            $this->hours = $default;
            return;
        }
        
        // Make sure it's at most two digits
        if ( strlen( $hours ) > 2 ) {
            $hours = ltrim( $hours, '0' );
            $hours = substr( $hours, 0, 2 );
        }
        
        // Convert 24 hour to 12 hour
        if ( $hours > 12 && $hours < 24 ) {
            $hours -= 12;
        }
        // Make sure it's 1 or 2 digits
        elseif ( $hours > 24 ) {
            $hours = $default;
        }
        
        $this->hours = $hours;
    }
    
    /*
     * Correctly format the minutes value
     */
    private function setMinutes( $minutes )
    {
        $default = '00';
        
        if ( ! $minutes ) {
            $this->minutes = $default;
            return;
        }

        $minutes = preg_replace( '![^\d]!', '', $minutes );
        
        $count = strlen( $minutes );
        
        // Make sure it's two digits
        if ( $count > 2 ) {
            $minutes = substr( $minutes, 0, 2 );
        }
        elseif ( $count == 1 ) {
            $this->minutes = '0' . $minutes;
            return;
        }
        elseif ( $count == 0 ) {
            $this->minutes = $default;
            return;
        }
        
        // Make sure it's withing the range
        if ( $minutes > 59 ) {
            $this->minutes = $default;
            return;
        }
        
        $this->minutes = $minutes;
    }
    
    /*
     * Set the meridiem
     */
    private function setMeridiem( $meridiem )
    {
        $this->meridiem = ( stripos( $meridiem, 'pm') ) ? 'pm' : 'am';
    }
    
    /*
     * Check if it's a valid date
     */
    public function isValid()
    {
        if ( ! $this->value ) {
            return false;
        }

        $regex = '/^(0?\d)|(1[0-2]):([0-5]\d)\s?(a|pm)$i/';
        if ( preg_match($regex, $this->value) != 1 ) {
            return false;
        }
        
        return true;
    }
    
    /*
     * Return the time as the number of seconds from 0
     */
    public function getSeconds()
    {
        $seconds = 0;
        
        $seconds += ( $this->minutes * 60 );
        
        if ( $this->hours < 12 ) {
            $seconds += ( $this->hours * 60 * 60 );
        }
        if ( $this->meridiem == 'pm' ) {
            $seconds += 12 * 60 * 60;
        }
        
        return $seconds;
    }
}
