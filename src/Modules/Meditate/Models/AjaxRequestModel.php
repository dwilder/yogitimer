<?php
namespace Src\Modules\Meditate\Models;

use Src\Includes\SuperClasses\Model;
use Src\Includes\Session\Session;
use Src\Includes\User\User;
use Src\Includes\Data\SaveMeditation;

class AjaxRequestModel extends Model
{
    /*
     * Submitted data
     */
    protected $submission;
    
    /*
     * Run
     */
    public function run()
    {
        $this->process();
    }
    
    /*
     * Process ajax request
     */
    protected function process()
    {
        $this->submission = json_decode( file_get_contents( 'php://input' ) );
        
        if ( ! $this->submission ) {
            exit;
        }

        //echo var_dump( $this->submission );

        $user = User::getInstance();
        
        if ( $user->isSignedIn() ) {
            $this->saveMeditation();
            echo 'SAVED';
        }
        else {
            $this->storeMeditation();
            echo 'LOGIN';
        }
        exit;
    }
    
    /*
     * Save the meditation
     */
    protected function saveMeditation()
    {
        $sm = new SaveMeditation;
        $sm->setData( $this->submission );
        $sm->save();
    }
    
    /*
     * Store the meditation in the session
     */
    protected function storeMeditation()
    {
        $session = Session::getInstance();
        $m = serialize( $this->submission );
        $session->set( 'meditation', $m );
    }
}
