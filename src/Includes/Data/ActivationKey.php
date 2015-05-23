<?php
namespace Src\Includes\Data;

/*
 * Generates an activation key
 */

class ActivationKey extends AbstractDataValue
{
    /*
     * Store the value
     */
    protected $value;
    
    /*
     * Set the value
     */
    public function set()
    {
        if ( ! $this->value ) {
            $this->generate();
        }
    }
    
    /*
     * Return the value
     */
    public function get()
    {
        $this->set();
        
        return $this->value;
    }
    
    /*
     * Generate the activation key
     */
    protected function generate()
    {
		$this->value = md5(uniqid(rand(), true));
    }
}
