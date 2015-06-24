<?php
namespace Src\Includes\User;

use Src\Includes\SuperClasses\AbstractCrud;
use Src\Includes\Database\DB;

class UserImages extends AbstractCrud
{
    /*
     * User Image data elements
     */
    protected $id = null;
    protected $user_id = null;
    protected $profile = null;
    protected $banner = null;
    protected $date_added = null;
    protected $date_modified = null;
    
    /*
     * Get an image
     */
    public function getImage( $type = null )
    {
        switch ( $type ) {
            case 'banner':
                return $this->banner;
                break;
            case 'profile':
            default:
                return $this->profile;
                break;
        }
    }
    
    /*
     * Create
     */
    public function create()
    {
        if ( ! $this->user_id ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = "INSERT INTO user_images (
            user_id,
            profile,
            banner,
            date_added
        ) VALUES (
            :user_id,
            :profile,
            :banner,
            CURRENT_TIMESTAMP()
        )";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':user_id', $this->user_id );
        $sh->bindParam(':profile', $this->profile );
        $sh->bindParam(':banner', $this->banner );
        
        $sh->execute();
        
        if ( $sh->rowCount() == 1 ) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }
    
    /*
     * Read
     */
    public function read()
    {
        if ( ! $this->user_id ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = "SELECT * FROM user_images WHERE user_id=:user_id";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':user_id', $this->user_id );
        $sh->execute();
        
        if ( $sh->rowCount() == 0 ) {
            $this->create(); // Need to create new table rows for existing users
            return false;
        }
        $this->original = $sh->fetch(\PDO::FETCH_ASSOC);
        if ( ! $this->original ) {
            $this->original = array();
            return false;
        }
        foreach ( $this->original as $k => $v ) {
            $this->$k = $v;
        }
        return true;
    }
    
    /*
     * Update
     */
    public function update()
    {
        if ( ! $this->user_id ) {
            return false;
        }
        
        if ( ! $this->isChanged() ) {
            return true;
        }
        
        $pdo = DB::getInstance();
        
        $q = "UPDATE user_images SET
            profile=:profile,
            banner=:banner
            WHERE user_id=:user_id
            LIMIT 1";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':profile', $this->profile );
        $sh->bindParam(':banner', $this->banner );
        $sh->bindParam(':user_id', $this->user_id );
        
        $sh->execute();
        
        if ( $sh->rowCount() == 1 ) {
            return true;
        }
        return false;
        
    }
    
    /*
     * Delete
     */
    public function delete()
    {
        return false;
    }
}
