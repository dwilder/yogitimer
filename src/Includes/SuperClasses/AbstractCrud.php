<?php
namespace Src\Includes\SuperClasses;

abstract class AbstractCrud
{
    /*
     * Original data
     */
    protected $original = array();
    
    /*
     * Set data
     */
    public function set( $key, $value = null )
    {
        $this->$key = $value;
    }
    
    /*
     * Get data
     */
    public function get( $key )
    {
        if ( isset( $this->$key ) ) {
            return $this->$key;
        }
        return null;
    }
    
    /*
     * Create
     */
    abstract public function create();
    
    /*
     * Read
     */
    abstract public function read();
    
    /*
     * Update
     */
    abstract public function update();
    
    /*
     * Delete
     */
    abstract public function delete();
    
    /*
     * Check if values have changed from the original values
     */
    public function isChanged()
    {
        foreach ( $this->original as $k => $v ) {
            if ( $this->$k != $v ) {
                return true;
            }
        }
        return false;
    }
}
