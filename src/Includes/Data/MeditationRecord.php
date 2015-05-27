<?php
namespace Src\Includes\Data;

use Src\Includes\SuperClasses\AbstractCrud;
use Src\Includes\Database\DB;
use Src\Includes\User\User;
use Src\Includes\Session\Session;

/*
 * Manage data for a single meditation
 */
class MeditationRecord extends AbstractCrud
{
    /*
     * Meditation record data
     */
    protected $id;
    protected $user_id;
    protected $start_time;
    protected $duration;
    protected $add_method;
    protected $status;
    protected $date_added;
    protected $date_modified;
    
    /*
     * Available add methods
     */
    private $add_methods = array(
        'organic',
        'form'
    );
    
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
        ) {
            $this->error = true;
            $this->message = 'MISSING DATA';
            return false;
        }
        
        $pdo = DB::getInstance();
        
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
        
        $stmt = $pdo->prepare($q);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':start_time', $this->start_time);
        $stmt->bindParam(':duration', $this->duration);
        $stmt->bindParam(':add_method', $this->add_method);
        
        if ( $stmt->execute() ) {
            $this->id = $pdo->lastInsertId();
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
        if ( ! $this->id ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = "SELECT * FROM meditation_records WHERE id=:id";
        
        $stmt = $pdo->prepare($q);
        $stmt->bindParam(':id', $this->id);
        
        if ( ! $stmt->execute() ) {
            return false;
        }
        $this->original = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ( $this->original ) {
            foreach ( $this->original as $k => $v ) {
                $this->$k = $v;
            }
            return true;
        }
        $this->original = array();
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
        ) {
            $this->error = true;
            $this->message = 'MISSING DATA';
            return false;
        }
        
        if ( ! $this->isChanged() ) {
            return true;
        }
        
        $pdo = DB::getInstance();
        
        $q = "UPDATE meditation_records SET start_time=:start_time, duration=:duration, date_modified=NOW() WHERE id=:id LIMIT 1";
        
        $stmt = $pdo->prepare($q);
        
        $stmt->bindParam(':start_time', $this->start_time);
        $stmt->bindParam(':duration', $this->duration);
        $stmt->bindParam(':id', $this->id);
        
        if ( ! $stmt->execute() ) {
            $this->message = 'NOT EXECUTED';
            //echo var_dump($stmt->errorInfo());
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
        if ( ! $this->id ) {
            return false;
        }
        
        if ( $this->isDeleted() ) {
            return true;
        }
        
        $pdo = DB::getInstance();
        
        $q = "UPDATE meditation_records SET status=0, date_modified=NOW() WHERE id=:id LIMIT 1";
        
        $stmt = $pdo->prepare($q);
        
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
        if ( ! $this->id ) {
            return false;
        }
        
        if ( ! $this->isDeleted() ) {
            return true;
        }
        
        $pdo = DB::getInstance();
        
        $q = "UPDATE meditation_records SET status=1, date_modified=NOW() WHERE id=:id LIMIT 1";
        
        $stmt = $pdo->prepare($q);
        
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
