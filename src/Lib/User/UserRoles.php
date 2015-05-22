<?php
namespace Src\Lib\User;

use Src\Lib\Data\Roles;

/*
 * This class retrieves and updates user roles
 *
 * Roles are stored as serialized arrays
 */
class UserRoles
{
    /*
     * Store the entry id, user_id, roles array, and timestamp
     */
    private $id = null;
    private $user_id = null;
    private $roles = array();
    private $date = null;
    
    /*
     * Store a reference to PDO
     */
    private $pdo = null;
    
    /*
     * Set the user id
     */
    public function setUserId( $user_id )
    {
        $this->user_id = $user_id;
    }
    
    /*
     * Set PDO
     */
    public function setPDO( \PDO $pdo )
    {
        $this->pdo = $pdo;
    }
    
    /*
     * Get roles from the database
     */
    public function read()
    {
        if ( $this->user_id && $this->pdo ) {
            $q = "SELECT * FROM user_roles WHERE user_id=:user_id LIMIT 1";
            
            $stmt = $this->pdo->prepare($q);
            $stmt->bindParam(':user_id', $this->user_id);
            
            if ( $stmt->execute ) {
                $r = $stmt->fetch(\PDO::FETCH_ASSOC);
            }
            if ( $r ) {
                $this->id = $r['id'];
                $this->roles = unserialize( $r['roles'] );
                $this->date = $r['date'];
                return true;
            }
        }
        return false;
    }
    
    /*
     * Return the roles
     */
    public function getRoles()
    {
        return $this->roles;
    }
    
    /*
     * Add a role
     */
    public function addRole( $role )
    {
        if ( in_array( $role, $this->roles ) ) {
            return;
        }
        $this->roles[] = $role;
    }
    /*
     * Remove a role
     */
    public function removeRole( $role )
    {
        $offset = array_search( $this->roles );
        if ( $offset === false ) {
            return;
        }
        array_splice( $this->roles, $offset, 1 );
    }
    
    /*
     * Update roles to the database
     */
    public function update()
    {
        if ( $this->user_id && $this->pdo ) {
            // Serialize the roles array
            $roles = serialize( $this->roles );
            
            $q = "UPDATE users_roles (roles) VALUES (:roles) WHERE user_id=:user_id LIMIT 1";
            
            $stmt = $this->pdo->prepare($q);
            $stmt->bindParam(':roles', $roles);
            $stmt->bindParam(':user_id', $this->user_id);
            
            if ( $stmt->execute() ) {
                //Hooray!!!
                return true;
            }
        }
        return false;
    }
    
    /*
     * Create an entry in the database
     */
    public function create()
    {
        if ( $this->user_id && $this->pdo && ! empty( $this->roles ) ) {
            // Serialize the roles array
            $roles = serialize( $this->roles );
            
            $q = "INSERT INTO user_roles (user_id, roles) VALUES (:user_id, :roles)";
            
            $stmt = $this->pdo->prepare($q);
            $stmt->bindParam(':user_id', $this->user_id);
            $stmt->bindParam(':roles', $roles);
            
            if ( $stmt->execute() ) {
                return true;
            }
        }
        return false;
    }
}
