<?php
namespace Src\Lib\User;

class UserImage
{
    /*
     * User Image data elements
     */
    protected $id = null;
    protected $user_id = null;
    protected $image_type = null;
    protected $hash = null;
    protected $extension = null;
    protected $date_added = null;
    protected $date_modified = null;
    
    /*
     * Set data element
     */
    public function set( $key, $value )
    {
        $this->$key = $value;
    }
    
    /*
     * Get a data element
     */
    public function get( $key )
    {
        if ( isset( $this->$key ) ) {
            return $this->$key;
        }
        return null;
    }
    /*
     * Return the HTML for display
     */
    public function getHtml()
    {
        // Path to uploads directory
        $dir = '/uploads/';
        
        // Path to default image
        $default = '/assets/images/user_' . $this->image_type . '.jpg';
        
        $ground = '<div class="user-image-' . $this->image_type . '">';
        $ground .= '<img src="';
        
        $path = '';
        if ( $this->hash && $this->extension ) {
            $path .= $dir;
            $path .= $this->hash . '.' . $this->extension;
        } else {
            $path .= $default;
        }
            
        $fruition = '" alt="' . $this->image_type . ' image" /></div>';

        return $ground . $path . $fruition;
    }
    
    /*
     * Test if the image exists
     */
    protected function doesFileExist()
    {
        
    }
}
