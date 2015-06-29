<?php
namespace Src\Modules\Meditate\Models;

use Src\Includes\SuperClasses\Model;
use Src\Includes\User\User;
use Src\Includes\Data\MeditationRecord;

class MeditateModel extends Model
{
    /*
     * Objects
     */
    protected $meditation_record;
    
	/*
	 * Run
	 */
	public function run()
	{
        $this->setMeditationRecord();
        $this->setInitialValues();
	}
    
    /*
     * Set the meditation record
     */
    private function setMeditationRecord()
    {
        $this->meditation_record = new MeditationRecord;
        $this->meditation_record->readLast();
    }
    
    /*
     * Set initial values for the meditation
     */
    private function setInitialValues()
    {
        // Preparation
        $this->data['sections'][0] = array(
            'name' => 'Preparation',
            'timed' => true,
            'times' => 'short',
            'time' => 1,
            'counted' => false,
            'counts' => null,
            'count' => null
        );
        
        // Meditation
        $this->data['sections'][1] = array(
            'name' => 'Meditation',
            'timed' => true,
            'times' => 'long',
            'counted' => false,
            'counts' => null,
            'count' => null
        );
        $duration = $this->meditation_record->get('duration');
        if ( $duration ) {
            $this->data['sections'][1]['time'] = $duration;
        } else {
            $this->data['sections'][1]['time'] = 5;
        }

        // Cool Down
        $this->data['sections'][2] = array(
            'name' => 'Cool Down',
            'timed' => true,
            'times' => 'medium',
            'time' => 1,
            'counted' => false,
            'counts' => null,
            'count' => null
        );
        
        // Gong
        $this->data['gong'] = 'all';
    }
}
