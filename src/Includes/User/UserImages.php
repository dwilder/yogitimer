<?php
namespace Src\Lib\User;

/*
 * Looks up images for a single user.
 * Creates and returns UserImage objects for each user image
 */

class UserImages
{
    /*
     * Store UserImage objects in an array
     */
    protected $images = array();
    
    /*
     * Store PDO
     */
    protected $pdo = null;
        
    /*
     * Set PDO
     */
    public function setPDO( PDO $pdo )
    {
        $this->pdo = $pdo;
    }
    
    /*
     * Get user images from the DB based on user id
     */
    public function setImages( $user_id )
    {
        // Look in the database
        if ( $this->pdo ) {
            $q = "SELECT * FROM user_images WHERE user_id=:user_id";
            
            $stmt = $this->pdo->prepare($q);
            $stmt->bindParam(':user_id', $user_id);
            
            if ( $stmt->execute ) {
                $stmt->fetchAll(PDO::FETCH_CLASS, 'UserImage');
            }
        }
        
        // Check if there is a profile image
        if ( ! $this->testForImage('profile') ) {
            $this->setDefaultImage( 'profile' );
        }
        
        // Check if there is a background image
        if ( ! $this->testForImage('background') ) {
            $this->setDefaultImage( 'background' );
        }
    }
    
    protected function testForImage( $type )
    {
        if ( ! empty( $this->images ) ) {
            foreach ( $this->images as $image ) {
                if ( $image->get( 'image_type' ) == $type ) {
                    return true;
                }
            }
        }
        return false;
    }
    protected function setDefaultImage( $type )
    {
        $image = new UserImage;
        $image->set('image_type', $type);
        $this->images[] = $image;
    }
    
    /*
     * Return a user image of a particular type
     */
    public function getImage( $type )
    {
        if ( empty( $this->images ) ) {
            $this->setImages;
        }
        
        foreach ( $this->images as $image ) {
            if ( $image->get( 'image_type') == $type ) {
                return $image;
            }
        }
        
        return false;
    }
}
