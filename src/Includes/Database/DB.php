<?php
namespace Src\Includes\Database;

// Singleton

class DB
{
    /*
     * Store the instance
     */
    static private $instance = null;
    
    /*
     * Don't allow duplication
     */
    public function __construct( $dsn, $user, $password ) {
        try {
            self::$instance = new \PDO( $dsn, $user, $password );
        }
        catch (\PDOException $e) {
            echo 'An error occurred. Please contact the administrator.';
            exit;
        }
    }
    private function __clone() {}
        
    /*
     * Get the instance
     */
    static public function getInstance()
    {
        return self::$instance;
    }
}
