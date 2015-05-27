<?php
namespace Src\Modules\Journal\Models;

use Src\Includes\SuperClasses\Model;
use Src\Includes\User\User;
use Src\Includes\Data\MeditationRecords;
use Src\Modules\Journal\Helpers\tDummyData;

/*
 * Returns an array of meditations for a given user
 */
class JournalModel extends Model
{
    use tDummyData;
    
    /*
     * Store Meditation Records object
     */
    private $records;
    
    /*
     * Run
     */
    public function run()
    {
		$this->setData();
    }
    
	/*
	 * Set the meditation data
	 */
	protected function setData()
	{
        // Testing data
		//$this->data = $this->dummyData();
        
        $this->records = new MeditationRecords;
        
        $user = User::getInstance();
        if ( ! $this->records->read( $user->get('id') ) ) {
            return;
        }
        
        $this->data = $this->records->get();
        
        // Convert date to times
        $count = count( $this->data );
        for ( $i = 0; $i < $count; $i++ ) {
            $this->data[$i]['start_time'] = strtotime( $this->data[$i]['start_time'] );
        }
	}
	
}