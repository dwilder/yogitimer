<?php
namespace Src\Includes\User;

use Src\Includes\SuperClasses\AbstractCrud;
use Src\Config\Config;
use Src\Includes\Database\DB;
use Src\Includes\Session\Session;
use Src\Includes\User\UserImages;
use Src\Includes\User\UserRoles;

class User extends AbstractCrud
{
    /*
     * Store the instance of itself
     */
    static private $instance = null;
    
    /*
     * Store important user data
     */
    protected $id = null;
    protected $username = null;
    protected $email = null;
    protected $registered_email = null;
    protected $pass = null;
    protected $activation_key = null;
    protected $status = null;
    protected $level = 'beginner';
    protected $directory = null;
    protected $date_added = null;
    protected $date_modified = null;
    
    /*
     * User role(s)
     *
     * null, meditator, administrator
     */
    protected $user_roles = array();
    
    /*
     * User images
     */
    protected $images = null;
    
    /*
     * Prevent duplicates
     */
    private function __construct() {
        $this->images = new UserImages();
    }
    private function __clone() {}
    
    /*
     * Return the instance
     */
    static function getInstance()
    {
        if ( self::$instance == null ) {
            self::$instance = new User();
        }
        return self::$instance;
    }
    
    /*
     * Set an image name
     */
    public function setImage( $type, $image )
    {
        $this->images->set( $type, $image );
    }
    
    /*
     * Get an image
     */
    public function getImage( $type = null )
    {
        switch ( $type ) {
            case 'banner':
                return $this->getImagePath('banner');
                break;
            case 'profile':
            default:
                return $this->getImagePath('profile');
                break;
        }
    }
    
    /*
     * Return a specific image path
     */
    protected function getImagePath( $type )
    {
        if ( ! $this->images || ! $this->images->get( $type ) ) {
            return '/assets/img/users/' . $type . '.jpg';
        }
        return '/profile_image/' . $this->directory . '/' . $this->images->get( $type );
    }
    
    /*
     * Update images
     */
    public function updateImages()
    {
        return $this->images->update();
    }
    
    /*
     * Create a user
     */
    public function create()
    {
        if ( ! $this->email || ! $this->pass ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
		// Build the query
		$q = 'INSERT INTO users (
			username,
			email,
			registered_email,
			pass,
			activation_key,
			status,
            directory,
			date_added
		) VALUES (
			:username,
			:email,
			:registered_email,
			:pass,
			:activation_key,
			:status,
            :directory,
			UTC_TIMESTAMP()
		)';
	
		$sh = $pdo->prepare($q);
		
		$sh->bindValue(':username', $this->username, \PDO::PARAM_STR);
		$sh->bindValue(':email', $this->email, \PDO::PARAM_STR);
		$sh->bindValue(':registered_email', $this->email, \PDO::PARAM_STR);
		$sh->bindValue(':pass', $this->pass, \PDO::PARAM_STR);
		$sh->bindValue(':activation_key', $this->activation_key, \PDO::PARAM_STR);
		$sh->bindValue(':status', $this->status, \PDO::PARAM_INT);
		$sh->bindValue(':directory', $this->directory, \PDO::PARAM_STR);
		
		// Check for success and get the ID
		if ( $sh->execute() ) {
			$this->id = $pdo->lastInsertId();
            $this->images->set( 'user_id', $this->id );
            $this->images->create();
            return true;
		}
		return false;
    }
    
    /*
     * Get user data from the database
     */
    public function read()
    {
        if ( ! $this->id ) {
            return false;
        }
        
        $pdo = DB::getInstance();
    
        $q = 'SELECT * FROM users WHERE id=:id LIMIT 1';
        
        $sh = $pdo->prepare($q);
        $sh->bindParam( ':id', $this->id );
        $sh->execute();
        
        if ( ! $sh->rowCount() == 1 ) {
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
        
        $this->images->set('user_id', $this->id);
        $this->images->read();
        // Get user roles
        $this->setUserRoles();
        
        // If we've made it this far, the user wasn't found. Make it anonymous.
        
    }
    
    /*
     * Update
     */
    public function update()
    {
        if ( ! $this->id ) {
            return false;
        }
        
        if ( ! $this->isChanged() ) {
            echo 'no change';
            return true;
        }
        
        $pdo = DB::getInstance();

        $q = 'UPDATE users SET
            username=:username,
            email=:email,
            pass=:pass,
            activation_key=:activation_key,
            status=:status
        WHERE id=:id
        LIMIT 1';
        
        $sh = $pdo->prepare($q);
        $sh->bindParam( ':username', $this->username );
        $sh->bindParam( ':email', $this->email );
        $sh->bindParam( ':pass', $this->pass );
        $sh->bindParam( ':activation_key', $this->activation_key );
        $sh->bindParam( ':status', $this->status );
        $sh->bindParam( ':id', $this->id );
        
        if ( $sh->execute() ) {
            return true;
        }
        return false;
    }
    
    /*
     * Delete
     */
    public function delete()
    {
        if ( ! $this->id ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = "UPDATE users SET status=3 WHERE id=:id LIMIT 1";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':id', $this->id);
        $sh->execute();
        
        if ( $sh->rowCount() == 1 ) {
            return true;
        }
        return false;
    }
    
    /*
     * Set the user roles
     */
    protected function setUserRoles()
    {
        $roles = new UserRoles;
        
        $roles->setUserId( $this->id );
        $roles->read();
        
        $this->user_roles = $roles->getRoles();
    }
    
    /*
     * Check if the user has an account that is active
     */
    public function isActive()
    {
        if ( $this->id && $this->activation_key ) {
            return true;
        }
        return false;
    }
    
    /*
     * Check if the user is signed in
     */
    public function isSignedIn()
    {
        return ( $this->id ) ? true : false;
    }
    
    /*
     * Checks whether the user has a given role
     */
    public function hasRole( $role )
    {
        if ( in_array( $role, $this->user_roles ) ) {
            return true;
        }
        return false;
    }
    
    /*
     * Check if the status is delete
     */
    public function isDeleted()
    {
        if ( $this->status == 3 ) {
            return true;
        }
        return false;
    }
}
