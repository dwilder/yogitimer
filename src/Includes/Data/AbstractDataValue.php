<?php
namespace Src\Lib\Data;

class AbstractDataValue
{
    /*
     * Store the value
     */
    protected $value;
    
    /*
     * Get the value
     */
    public function get()
    {
        if ( ! $this->value ) {
            $this->set();
        }
        return $this->value;
    }
}
