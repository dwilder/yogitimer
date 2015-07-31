<?php
namespace Src\Includes\Data;

use Src\Includes\Database\DB;
use Src\Includes\User\User;

class MeditationPractices
{
    /*
     * Store the data
     */
    private $data = array();
    
    /*
     * The default practice
     */
    private $default = array(
       'id' => 0,
       'user_id' => null,
       'name' => 'Meditation',
       'goal_time' => null,
       'date_added' => null,
       'date_modified' => null
    );
    
    /*
     * Return the data
     */
    public function get()
    {
        $data = $this->data;
        $data[] = $this->default;
        return $data;
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
        
        $q = 'SELECT * FROM meditation_practices WHERE user_id=:user_id';
        
        $stmt = $pdo->prepare($q);
        $stmt->bindParam(':user_id', $user_id);
        
        if ( $stmt->execute() ) {
            $this->data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return true;
        }
        return false;
    }
    
    /*
     * Return an array mapping ids to names
     */
    public function getIdToNameArray( $include_default = false )
    {
        $map = array();
        
        $data = $this->get();
        foreach ( $data as $row ) {
            if ( $row['id'] == 0 && ! $include_default ) {
                $map[$row['id']] = null;
                continue;
            }
            $map[$row['id']] = $row['name'];
        }
        
        return $map;
    }
}