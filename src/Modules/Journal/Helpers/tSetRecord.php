<?php
namespace Src\Modules\Journal\Helpers;

use Src\Lib\User\User;
use Src\Lib\Data\MeditationRecord;;
use Src\Lib\Data\DateTime;

trait tSetRecord
{
    /*
     * Store datetime
     */
    protected $datetime;
    
    /*
     * Attempt to get the record from the database
     */
    protected function setRecord()
    {
        $this->record = new MeditationRecord;
        
        if ( ! isset( $_GET['mid'] ) ) {
            $this->error = true;
            $this->data['status'] = 'NOT FOUND';
            return;
        }
        
        $this->data['id'] = preg_replace('/[^0-9]/', '', $_GET['mid'] );
        
        $this->record->set('id', $this->data['id']);
        $this->record->setPDO( $this->pdo );
        if ( ! $this->record->read() ) {
            $this->error = true;
            $this->data['status'] = 'NOT FOUND';
            return;
        }
        
        $user = User::getInstance();
        $this->data['user_id'] = $user->get('id');
        
        if ( $this->record->get('user_id') != $this->data['user_id'] ) {
            $this->error = true;
            $this->data['status'] = 'NOT FOUND';
            return;
        }
        
        $this->data['start_time']       = $this->record->get('start_time');
        $this->data['timezone_offset']  = $this->record->get('timezone_offset');
        $this->data['duration']         = $this->record->get('duration');
        $this->data['add_method']       = $this->record->get('add_method');
        
        $this->datetime = new DateTime($this->data['start_time']);
        $this->data['date'] = $this->datetime->getDate();
        $this->data['long_date'] = $this->datetime->getLongDate();
        $this->data['time'] = $this->datetime->getTime();
    }
}
