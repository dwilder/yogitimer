<?php
namespace Src\Includes\Data;

use Src\Includes\SuperClasses\AbstractCrud;
use Src\Includes\Database\DB;
use Src\Includes\User\User;

class MeditationPractice extends AbstractCrud
{
    /*
     * Meditation record data
     */
    protected $id;
    protected $user_id;
    protected $name;
    protected $goal_time;
    protected $date_added;
    protected $date_modified;
    
    /*
     * Constructor
     */
    public function __construct()
    {
        $this->id = null;
        $this->user_id = null;
        $this->name = null;
        $this->goal_time = null;
        $this->date_added = null;
        $this->date_modified = null;
    }
    
    /*
     * Create
     */
    public function create()
    {
        if ( ! $this->user_id || ! $this->name ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = "INSERT INTO meditation_practices (
            user_id,
            name,
            goal_time,
            date_added
        ) VALUES (
            :user_id,
            :name,
            :goal_time,
            CURRENT_TIMESTAMP()
        )";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam( ':user_id', $this->user_id );
        $sh->bindParam( ':name', $this->name );
        $sh->bindParam( ':goal_time', $this->goal_time );
        
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
        if ( ! $this->id ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = "SELECT * FROM meditation_practices WHERE id=:id";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam( ':id', $this->id );
        $sh->execute();
        
        if ( $sh->rowCount() != 1 ) {
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
        if ( ! $this->id || ! $this->name ) {
            return false;
        }
        
        if ( ! $this->isChanged() ) {
            return true;
        }
        
        $pdo = DB::getInstance();
        
        $q = "UPDATE meditation_practices SET name=:name, goal_time=:goal_time WHERE id=:id LIMIT 1";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam( ':name', $this->name );
        $sh->bindParam( ':goal_time', $this->goal_time );
        $sh->bindParam( ':id', $this->id );
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
        if ( ! $this->id ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = 'DELETE FROM meditation_practices WHERE id=:id';
        
        $sh = $pdo->prepare($q);
        $sh->bindParam( ':id', $this->id );
        
        if ( $sh->execute() ) {
            return true;
        }
        return false;
    }
}
