<?php
namespace Src\Includes\Reference;

class Months
{
    private $months = array(
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December'
    );
        
    /*
     * Get a month name
     */
    public function getMonthName( $index )
    {
        $index = $index + 1 - 1;
        if ( $index < 1 ) {
            $index = 1;
        }
        elseif ( $index > 12 ) {
            $index = ( $index % 12 ) + 1;
        }
        
        return $this->months[$index];
    }
}
