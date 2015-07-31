<?php
namespace Src\Modules\Practices\Models;

use Src\Includes\SuperClasses\Model;
use Src\Modules\Practices\Helpers\tSetPractice;
use Src\Includes\User\User;
use Src\Includes\Data\MeditationPractice;
use Src\Includes\Data\MeditationPracticeName;
use Src\Includes\Data\MeditationPracticeGoalTime;
use Src\Includes\Session\SessionMessage;

class EditModel extends Model
{
    use tSetPractice;
    
    /*
     * Objects
     */
    private $practice;
    private $practice_name;
    private $practice_goal_time;
    
    /*
     * Properties
     */
    protected $error = false;
    
    /*
     * Run
     */
    public function run()
    {
        if ( ! $this->setPractice() ) {
            $this->redirect('practices');
        }
        
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $this->process();
        }
    }
    
    /*
     * Process the submission
     */
    protected function process()
    {
        $this->setMeditationPracticeName();
        $this->setMeditationPracticeGoalTime();
        
        if ( $this->error ) {
            return;
        }
        
        if ( $this->setMeditationPractice() ) {
            $this->setSessionMessage();
            $this->redirect('practices');
        }
    }
    
    /*
     * Process the name
     */
    protected function setMeditationPracticeName()
    {
        if ( ! isset( $_POST['name'] ) ) {
            $this->error = true;
            $this->data['error']['name'] = 'You must set a practice name.';
            return;
        }
        
        $this->practice_name = new MeditationPracticeName( $_POST['name'] );
        
        if ( ! $this->practice_name->isValid() ) {
            $this->error = true;
            $this->data['error']['name'] = $this->practice_name->getError();
            return;
        }
    }
    
    /*
     * Process the time goal
     */
    protected function setMeditationPracticeGoalTime()
    {
        if ( ! isset( $_POST['goal_time'] ) ) {
            $time = null;
        }
        else {
            $time = $_POST['goal_time'];
        }
        
        $this->practice_goal_time = new MeditationPracticeGoalTime( $time );
    }
    
    /*
     * Add the practice entry
     */
    protected function setMeditationPractice()
    {
        $this->practice->set( 'name', $this->practice_name->getValue() );
        $this->practice->set( 'goal_time', $this->practice_goal_time->getValue() );
        
        if ( ! $this->practice->update() ) {
            $this->error = true;
            $this->data['error']['form'] = 'An error occurred while updating your practice. Please try again.';
            return false;
        }
        return true;
    }
    
    /*
     * Set a Session message
     */
    protected function setSessionMessage()
    {
        $sm = new SessionMessage;
        
        $sm->setSource( 'add_practice' );
        $sm->setDestination( 'practices' );
        $sm->setMessage( $this->practice_name->getValue() . ' has been updated.' );
        $sm->setMeta( array( 'success' => true ) );
        
        $sm->store();
    }
}
