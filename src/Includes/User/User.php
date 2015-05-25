<?php
namespace Src\Includes\User;

use Src\Includes\Database\DB;
use Src\Includes\Session\Session;
use Src\Includes\User\UserRoles;

class User
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
    protected $profile_image = null;
    protected $background_image = null;
    
    /*
     * Prevent duplicates
     */
    private function __construct() {}
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
     * Getter and setter
     */
    public function set( $key, $value = null )
    {
        $this->$key = $value;
    }
    public function get( $key )
    {
        if ( $this->$key ) {
            return $this->$key;
        }
        return null;
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
			date_added
		) VALUES (
			:username,
			:email,
			:registered_email,
			:pass,
			:activation_key,
			:status,
			UTC_TIMESTAMP()
		)';
	
		$stmt = $pdo->prepare($q);
		
		$stmt->bindValue(':username', $this->username, \PDO::PARAM_STR);
		$stmt->bindValue(':email', $this->email, \PDO::PARAM_STR);
		$stmt->bindValue(':registered_email', $this->email, \PDO::PARAM_STR);
		$stmt->bindValue(':pass', $this->pass, \PDO::PARAM_STR);
		$stmt->bindValue(':activation_key', $this->activation_key, \PDO::PARAM_STR);
		$stmt->bindValue(':status', $this->status, \PDO::PARAM_INT);
		
		// Check for success and get the ID
		if ( $stmt->execute() ) {
			$this->id = $pdo->lastInsertId();
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
        
        $stmt = $pdo->prepare($q);
        $stmt->bindParam( ':id', $this->id );
        
        if ( $stmt->execute() ) {
            $r = $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        if ( $r ) {
            foreach ( $r as $k => $v ) {
                $this->$k = $v;
            }
        }
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
}
