<?php
namespace Src\Lib\User;

use Src\Lib\User\UserRoles;

/*
 * Singleton
 */

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
     * PDO object
     */
    protected $pdo;
    
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
     * Set the PDO reference
     */
    public function setPDO( \PDO $pdo )
    {
        $this->pdo = $pdo;
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
     * Get user data from the database
     */
    public function read()
    {
        if ( $this->id && $this->pdo ) {
            $q = 'SELECT * FROM users WHERE id=:id LIMIT 1';
            
            $stmt = $this->pdo->prepare($q);
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
        }
        
        // If we've made it this far, the user wasn't found. Make it anonymous.
        
    }
    
    /*
     * Set the user roles
     */
    protected function setUserRoles()
    {
        $roles = new UserRoles;
        
        $roles->setPDO( $this->pdo );
        $roles->setUserId( $this->id );
        $roles->read();
        
        $this->user_roles = $roles->getRoles();
    }
    
    /*
     * Create a user
     */
    public function create()
    {
        
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
