<?php
namespace Src\Modules\Practices\Helpers;

use Src\Includes\Data\MeditationPractice;
use Src\Includes\User\User;

trait tSetPractice
{
    /*
     * Attempt to get the practice from the database
     */
    protected function setPractice()
    {
        $this->practice = new MeditationPractice;
        
        if ( ! isset( $this->request['id'] ) ) {
            $this->error = true;
            $this->data['status'] = 'NOT FOUND';
            return false;
        }
        
        $this->data['id'] = preg_replace('/[^0-9]/', '', $this->request['id'] );
        
        $this->practice->set('id', $this->data['id']);
        if ( ! $this->practice->read() ) {
            $this->error = true;
            $this->data['status'] = 'NOT FOUND';
            return false;
        }
        
        $user = User::getInstance();
        $this->data['user_id'] = $user->get('id');
        
        if ( $this->practice->get('user_id') != $this->data['user_id'] ) {
            $this->error = true;
            $this->data['status'] = 'NOT FOUND';
            return false;
        }
        
        $this->data['name']       = $this->practice->get('name');
        $this->data['goal_time']  = $this->practice->get('goal_time');
        
        return true;
    }
}
