<?php
namespace Src\Lib\Data;

class LoginToken
{
    /*
     * Store the token, user id
     */
    private $token = null;
    private $user_id = null;
    
    /*
     * Token data
     */
    private $data = array();
    
    /*
     * Store the PDO
     */
    private $pdo = null;
    
    /*
     * Set PDO
     */
    public function setPDO( \PDO $pdo )
    {
        $this->pdo = $pdo;
    }
    
    /*
     * Generate a token
     */
    public function generate()
    {
        $token = openssl_random_pseudo_bytes(32);
        $this->token = bin2hex($token);
        
        $this->create();
    }
    
    /*
     * Get the token value
     */
    public function getValue()
    {
        if ( $this->token ) {
            return $this->token;
        }
        return null;
    }
    
    /*
     * Set user id
     */
    public function setUserId( $user_id )
    {
        $this->user_id = $user_id;
    }
    
    /*
     * Add the token to the database
     */
    public function create()
    {
        if ( ! $this->token ) {
            $this->generate();
        }
        
        if ( ! $this->user_id || ! $this->pdo ) {
            return false;
        }
        
        // Delete all other tokens for this user
        $this->delete();
        
        $q = "INSERT INTO login_tokens (user_id, token, date_expires) VALUES (:user_id, :token, DATE_ADD(NOW(), INTERVAL 60 MINUTE))";
        
        $stmt = $this->pdo->prepare($q);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':token', $this->token);
        
        if ( $stmt->execute() ) {
            return true;
        }
        return false;
    }
    
    /*
     * Delete all tokens for this user
     */
    public function delete()
    {
        if ( ! $this->user_id || ! $this->pdo ) {
            return false;
        }
        
        $q = "DELETE FROM login_tokens WHERE user_id=:user_id";
        
        $stmt = $this->pdo->prepare($q);
        $stmt->bindParam(':user_id', $this->user_id);
        
        if ( $stmt->execute() ) {
            return true;
        }
        return false;
    }
    
    /*
     * Read from the database
     */
    public function read()
    {
        if ( ! $this->user_id || ! $this->pdo ) {
            return false;
        }
        
        $q = "SELECT * FROM login_tokens WHERE user_id=:user_id";
        
        $stmt = $this->pdo->prepare($q);
        $stmt->bindParam(':user_id', $this->user_id);
        
        if ( $stmt->execute() ) {
            $r = $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        if ( $r ) {
            foreach ( $r as $k => $v ) {
                $this->data[$k] = $v;
            }
            return true;
        }
        return false;
    }
    
    /*
     * Verify a token
     */
    public function verify( $user_id, $token )
    {
        $this->user_id = $user_id;
        
        if ( strlen( $token ) != 64 ) {
            return false;
        }
        
        $this->read();
        
        // Is there a token in the database?
        if ( ! isset( $this->data['token'] ) ) {
            return false;
        }
        
        // Do the tokens match?
        if ( $token != $this->data['token'] ) {
            return false;
        }
        
        // Has the token expired?
        if ( time() > strtotime( $this->data['date_expires'] ) ) {
            return false;
        }
        
        return true;
    }
}
