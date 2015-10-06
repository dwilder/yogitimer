<?php
namespace Src\Modules\Journal\Helpers;

use Src\Includes\User\User;
use Src\Includes\Data\Date;
use Src\Includes\Data\Time;

trait tSetSubmittedData
{
    /*
     * Store date, time
     */
    protected $meditation_practice_id;
    protected $date;
    protected $time;
    
    /*
     * Set data
     */
    protected function setSubmittedData()
    {
        $this->setUserId();
        $this->setMeditationPracticeId();
        $this->setStartTime();
        $this->setDuration();
        $this->setAddMethod();
    }
    
    /*
     * Validate and set user id
     */
    protected function setUserId()
    {
        $user = User::getInstance();
        if ( $user->isSignedIn() ) {
            $this->record->set('user_id', $user->get('id'));
            return;
        }
        $this->error = true;
        $this->data['error']['user'] = 'User is not logged in.';
    }
    
    /*
     * Validate and set meditation practice id
     */
    protected function setMeditationPracticeId()
    {
        $id = 0;
        if ( isset( $_POST['practice'] ) ) {
            $mpi = preg_replace('/[^0-9]/', '', $_POST['practice'] );
            if ( $this->practices->hasPractice( $mpi ) ) {
                $id = $mpi;
            }
        }
        
        $this->meditation_practice_id = $id;
        $this->data['practice'] = $id;
        $this->record->set( 'meditation_practice_id', $id );
    }
    
    /*
     * Validate and set start time. Includes date and time form elements
     */
    protected function setStartTime()
    {
        $date_is_valid = $this->setDate();
        $time_is_valid = $this->setTime();
        
        if ( ! $date_is_valid || ! $time_is_valid ) {
            return;
        }
        
        // Convert the separate date and time strings to a single UNIX datetime value
        $timestamp = ( strtotime( $this->date->getFormatted() ) + $this->time->getSeconds() );
        $this->data['start_time'] = date( 'Y-m-d H:i:s', $timestamp );
        $this->record->set('start_time', $this->data['start_time']);
    }
    protected function setDate()
    {
        $message = "Please enter a date in the correct format.";
        
        if ( ! isset( $_POST['date'] ) ) {
            $this->error = true;
            $this->data['error']['date'] = $message;
            return false;
        }
        
        $this->date = new Date($_POST['date']);
        $this->data['date'] = $this->date->get();
        
        if ( ! $this->date->isValid() ) {
            $this->error = true;
            $this->data['error']['date'] = $message;
            return false;
        }
        return true;
    }
    protected function setTime()
    {
        $message = "Please enter a time in the correct format.";
        
        if ( ! isset( $_POST['time'] ) ) {
            $this->error = true;
            $this->data['error']['time'] = $message;
            return false;
        }
        
        $this->time = new Time($_POST['time']);
        $this->data['time'] = $this->time->get();
        
        if ( ! $this->time->isValid() ) {
            $this->error = true;
            $this->data['error']['time'] = $message;
            return false;
        }
        return true;
    }
    protected function setDuration()
    {
        $message = 'Please set a duration for your meditation.';
        
        if ( ! isset( $_POST['duration'] ) ) {
            $this->error = true;
            $this->data['error']['duration'] = $message;
        }
        
        // Duration is a time in minutes
        $duration = trim( $_POST['duration'] ) ;
        $duration = preg_replace('![^0-9]!', '', $duration);
        
        if ( $duration <= 0 ) {
            $this->error = true;
            $this->data['error']['duration'] = $message;
            return;
        }

        $this->data['duration'] = $duration;
        $this->record->set('duration', $this->data['duration']);
    }
    protected function setAddMethod()
    {
        if ( isset( $_POST['add_method'] ) ) {
            $this->record->set('add_method', $_POST['add_method']);
        }
    }
}
