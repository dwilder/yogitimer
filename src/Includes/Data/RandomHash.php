<?php
namespace Src\Includes\Data;

use Src\Includes\Data\AbstractDataValue;

class RandomHash extends AbstractDataValue
{
    /*
     * Set a length for the return value
     */
    protected $length = 8;
    
    /*
     * Change the length
     */
    public function setLength( $length )
    {
        $length = preg_replace( '/[^0-9]/', '', $length );
        if ( $length > 0 ) {
            $this->length = $length;
        }
    }
    
    /*
     * Set
     */
    public function set()
    {
    	$random = rand(1, 1000) + time() + '2yiNKoGzT4=nMQOt|a*b9~6dz~fS8owfDD~tD4=a0oy';
    	for ($i = 0; $i < 50; $i += 1) {
    		$random = hash( 'sha1', $random, FALSE );
    	}
    	$this->value = substr( $random, 0, $this->length );
    }
}
