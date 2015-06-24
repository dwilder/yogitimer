<?php
namespace Src\Includes\Reference;

class AllowedImageTypes
{
    /*
     * A file type to test
     */
    protected $file_type;
    
    /*
     * Allowed file types
     */
    protected $types = array(
        'image/png' => 'png',
        'image/jpg' => 'jpg',
        'image/jpeg' => 'jpeg',
        'image/gif' => 'gif',
        'image/bmp' => 'bmp'
    );
    
    /*
     * Return the filetypes
     */
    public function get()
    {
        return $types;
    }
    
    /*
     * Set a filetype to test
     */
    public function setFiletype( $file_type )
    {
        $this->file_type = $file_type;
    }
    
    /*
     * Get the filetype
     */
    public function getExtension()
    {
        return $this->types[$this->file_type];
    }
    
    /*
     * Test an allowed file type
     */
    public function isAllowed( $file_type = null )
    {
        if ( ! $file_type ) {
            $file_type = $this->file_type;
        }
        
        if ( array_key_exists( $file_type, $this->types ) ) {
            return true;
        }
        return false;
    }
}
