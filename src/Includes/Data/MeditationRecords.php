<?php
namespace Src\Includes\Data;

use Src\Includes\User\User;

/*
 * Class to retrieve a user's meditation history.
 */
class MeditationRecords
{
    /*
     * Store the data
     */
    private $data = array();
    
    /*
     * Store PDO
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
     * Return the data
     */
    public function get()
    {
        return $this->data;
    }
    
    /*
     * Get the data from the database
     */
    public function read( $user_id = null )
    {
        if ( ! $user_id ) {
            $user = User::getInstance();
            $user_id = $user->get('id');
        }
        
        if ( ! $this->pdo ) {
            return;
        }
        
        $q = 'SELECT * FROM meditation_records WHERE user_id=:user_id AND status=1 ORDER BY start_time DESC';
        
        $stmt = $this->pdo->prepare($q);
        $stmt->bindParam(':user_id', $user_id);
        
        if ( $stmt->execute() ) {
            $this->data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return true;
        }
        return false;
    }
}
