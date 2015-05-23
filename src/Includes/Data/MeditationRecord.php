<?php
namespace Src\Includes\Data;

use Src\Includes\User\User;
use Src\Includes\Session\Session;

/*
 * Manage data for a single meditation
 */
class MeditationRecord
{
    /*
     * Meditation record data
     */
    private $id;
    private $user_id;
    private $start_time;
    private $duration;
    private $add_method;
    private $status;
    private $date_added;
    private $date_modified;
    
    /*
     * Available add methods
     */
    private $add_methods = array(
        'organic',
        'form'
    );
    
    /*
     * Store PDO
     */
    protected $pdo;

    /*
     * Track error
     */
    protected $error = false;
    protected $message;
    
    /*
     * Constructor
     */
    public function __construct()
    {
        $this->id = null;
        $this->user_id = null;
        $this->start_time = null;
        $this->duration = null;
        $this->add_method = null;
        $this->status = null;
        $this->date_added = null;
        $this->date_modified = null;
    }
    
    /*
     * Set PDO
     */
    public function setPDO( \PDO $pdo )
    {
        $this->pdo = $pdo;
    }
    
    /*
     * Set data
     */
    public function set( $key, $value = null )
    {
        $this->$key = $value;
    }
    
    /*
     * Get data
     */
    public function get( $key )
    {
        if ( isset( $this->$key ) ) {
            return $this->$key;
        }
        return null;
    }
    
    /*
     * Add a meditation to the database
     */
    public function create()
    {
        // Make sure the add method is OK
        $this->validateAddMethod();
        
        // Required data
        if (   ! $this->user_id 
            || ! $this->start_time
            || ! $this->duration
            || ! $this->add_method
            || ! $this->pdo
        ) {
            $this->error = true;
            $this->message = 'MISSING DATA';
            return false;
        }
        
        $q = "INSERT INTO meditation_records (
            user_id,
            start_time,
            duration,
            add_method,
            status,
            date_added
        ) VALUES (
            :user_id,
            :start_time,
            :duration,
            :add_method,
            1,
            UTC_TIMESTAMP()
        )";
        
        $stmt = $this->pdo->prepare($q);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':start_time', $this->start_time);
        $stmt->bindParam(':duration', $this->duration);
        $stmt->bindParam(':add_method', $this->add_method);
        
        if ( $stmt->execute() ) {
            $this->id = $this->pdo->lastInsertId();
            return true;
        }
        
        $error = true;
        $this->message = 'DATABASE FAILURE';
        return false;
    }
    
    /*
     * Read
     */
    public function read()
    {
        if ( ! $this->id || ! $this->pdo ) {
            return false;
        }
        
        $q = "SELECT * FROM meditation_records WHERE id=:id";
        
        $stmt = $this->pdo->prepare($q);
        $stmt->bindParam(':id', $this->id);
        
        if ( ! $stmt->execute() ) {
            return false;
        }
        $r = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ( $r ) {
            foreach ( $r as $k => $v ) {
                $this->$k = $v;
            }
            return true;
        }
        return false;
    }
    
    /*
     * Update
     */
    public function update()
    {
        // Required data
        if (   ! $this->start_time
            || ! $this->duration
            || ! $this->pdo
        ) {
            $this->error = true;
            $this->message = 'MISSING DATA';
            return false;
        }
        
        $q = "UPDATE meditation_records SET start_time=:start_time, duration=:duration, date_modified=NOW() WHERE id=:id LIMIT 1";
        
        $stmt = $this->pdo->prepare($q);
        
        $stmt->bindParam(':start_time', $this->start_time);
        $stmt->bindParam(':duration', $this->duration);
        $stmt->bindParam(':id', $this->id);
        
        if ( ! $stmt->execute() ) {
            $this->message = 'NOT EXECUTED';
            echo var_dump($stmt->errorInfo());
            return false;
        }
        
        if ( $stmt->rowCount() != 1 ) {
            return false;
        }
        
        return true;
    }
    
    /*
     * Delete
     */
    public function delete()
    {
        if ( ! $this->id || ! $this->pdo ) {
            return false;
        }
        
        $q = "UPDATE meditation_records SET status=0, date_modified=NOW() WHERE id=:id LIMIT 1";
        
        $stmt = $this->pdo->prepare($q);
        
        $stmt->bindParam(':id', $this->id);
        
        if ( ! $stmt->execute() ) {
            return false;
        }
        return true;
    }
    
    /*
     * Restore a meditation
     */
    public function restore()
    {
        if ( ! $this->id || ! $this->pdo ) {
            return false;
        }
        
        $q = "UPDATE meditation_records SET status=1, date_modified=NOW() WHERE id=:id LIMIT 1";
        
        $stmt = $this->pdo->prepare($q);
        
        $stmt->bindParam(':id', $this->id);
        
        if ( ! $stmt->execute() ) {
            return false;
        }
        if ( $stmt->rowCount() != 1 ) {
            return false;
        }
        return true;
    }
    
    /*
     * Validate the add method and force it to a value
     */
    private function validateAddMethod()
    {
        if ( $this->add_method != null && in_array( $this->add_method, $this->add_methods ) ) {
            return;
        }
        $this->add_method = 'organic';
    }
    
    /*
     * Determine if a record has delete status (status=0)
     */
    public function isDeleted()
    {
        if ( $this->status == 0 ) {
            return true;
        } elseif ( $this->status == 1 ) {
            return false;
        }
        return null;
    }
}
