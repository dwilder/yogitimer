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
     * Set the "saved" message
     */
    public function setSaved( $bool )
    {
        $this->data['saved'] = $bool;
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
        
        $duration = floor( $this->meditation_record->get('duration') );
        
        if ( $duration ) {
            if ( $duration > 240 ) {
                $duration = 240;
            }
            else if ( $duration > 120 && $duration % 15 != 0 ) {
                $duration = 15 * ( floor( $duration / 15 ) + 1 );
            }
            else if ( $duration % 5 != 0 ) {
                $duration = 5 * ( floor( $duration / 5 ) + 1 );
            }
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
