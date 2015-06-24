<?php
namespace Src\Includes\Image;

use Src\Includes\Reference\AllowedImageTypes;

class ImageUploader
{
    /*
     * Image data
     */
    protected $postname; // The file input name
    protected $file_name;
    protected $file_size;
    protected $file_type;
    protected $file_extension;
    
    protected $error = false;
    protected $error_message;
    
    /*
     * Image types object
     */
    protected $image_types;
    
    /*
     * Constructor
     */
    public function __construct( $postname = null )
    {
        $this->postname = $postname;
        $this->file_name = null;
        $this->file_size = null;
        $this->file_type = null;
        $this->file_extension = null;
    }
    
    /*
     * Get a value
     */
    public function get( $key )
    {
        return $this->$key;
    }
    
    /*
     * Set the postname
     */
    public function setPostname( $postname )
    {
        $this->postname = $postname;
    }
    
    /*
     * Get the filename
     */
    public function getFilename()
    {
        if ( ! $this->file_name || ! $this->file_extension ) {
            return false;
        }
        return $this->file_name . '.' . $this->file_extension;
    }
    
    /*
     * Set and validate the file data
     */
    public function setFile()
    {
        if ( ! $this->postname ) {
            $this->error_message = 'Coding error. Input name not set.';
            $this->error = true;
            return false;
        }
        
        if ( ! $this->hasImage() ) {
            return false;
        }
        
        $this->image_types = new AllowedImageTypes( $this->postname );
        $this->image_types->setFiletype( $_FILES[$this->postname]['type'] );
        
        if ( ! $this->image_types->isAllowed() ) {
            $this->error_message = 'File type is not allowed.';
            $this->error = true;
            return false;
        }
        
        $this->file_extension = $this->image_types->getExtension();
        
        $this->tmp_name = $_FILES[$this->postname]['tmp_name'];
        $this->file_size = $_FILES[$this->postname]['size'];
        
        $this->file_name = pathinfo( $_FILES[$this->postname]['name'], PATHINFO_FILENAME);

        $this->file_name = str_replace( ' ', '-', $this->file_name );
        $this->file_name = preg_replace( '/[^a-zA-Z0-9_-]/', '', $this->file_name );
        
        return true;
    }
    
    /*
     * Move the image to the proper directory
     */
    public function moveTo( $dir )
    {
        $location = $dir . '/' . basename( $this->file_name ) . '.' . $this->image_types->getExtension();
		move_uploaded_file( $this->tmp_name, $location );
		unset( $_FILES[$this->postname] );
    }
    
    /*
     * Test whether there is an image
     */
    public function hasImage()
    {
        if ( empty( $_FILES[$this->postname]['tmp_name'] ) ) {
            return false;
        }
        return true;
    }
    
    /*
     * Get an error message
     */
    public function getError()
    {
        return $this->error_message;
    }
}