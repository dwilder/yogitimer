<?php
namespace Src\Includes\Data;

use Src\Includes\Session\Session;
use Src\Includes\User\User;
use Src\Includes\Data\MeditationRecord;

class SaveMeditation
{
    /*
     * Data
     */
    protected $data;
    
    /*
     * Was it stored in a session?
     */
    protected $from_session = false;
    
    /*
     * Set data
     */
    public function setData( $data )
    {
        $this->data = $data;
    }
    
    /*
     * Save
     */
    public function save()
    {
        if ( ! $this->data || ! $this->setDataFromSession() ) {
            return;
        }
        
        $user = User::getInstance();
        
        $m = new MeditationRecord;
        
        $m->set( 'user_id', $user->get('id') );
        
        $s = $this->data->start_time;
        $s = str_replace( 'T', ' ', $s );
        $s = substr( $s, 0, strpos( $s, '.' ) );
        
        $m->set( 'start_time', $s );
        $m->set( 'add_method', 'organic' );
        
        foreach ( $this->data->sections as $section ) {
            if ( $section->name == 'Meditation' ) {
                $t = $section->time;
                $t = floor( $t );
                $m->set( 'duration', $section->time );
            }
        }
        
        //echo var_dump( $m );
        
        if ( $m->create() ) {
            if ( $this->from_session ) {
                $session = Session::getInstance();
                $session->set('meditation', null);
            }
            return true;
        }
        return false;
    }
    
    /*
     * Set data from session
     */
    private function setDataFromSession()
    {
        $session = Session::getInstance();
        
        $m = $session->get('meditation');
        
        if ( ! $m ) {
            return false;
        }

        $this->data = unserialize( $m );
    }
}
