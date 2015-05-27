<?php
namespace Src\Includes\Data;

use Src\Includes\Database\DB;
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
        
        $pdo = DB::getInstance();
        
        $q = 'SELECT * FROM meditation_records WHERE user_id=:user_id AND status=1 ORDER BY start_time DESC';
        
        $stmt = $pdo->prepare($q);
        $stmt->bindParam(':user_id', $user_id);
        
        if ( $stmt->execute() ) {
            $this->data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return true;
        }
        return false;
    }
}
