<?php
namespace Src\Modules\Meditate;

use Src\Includes\SuperClasses\UIController;
use Src\Includes\Session\Session;
use Src\Includes\User\User;
use Src\Modules\Meditate\Models\MeditateModel;
use Src\Modules\Meditate\Views\MeditateView;
use Src\Includes\Data\SaveMeditation;

/*
 * Controller class for the meditation section.
 *
 * - Meditation Form
 * - Meditation Timer
 * - Autolog Meditation Time
 * - Suggest login to autolog meditation time
 */

class Controller extends UIController
{
    /*
     * Meditation in session has been saved
     */
    protected $saved = false;
    
    /*
     * Run
     */
    public function run()
    {
        $this->setClass();
        $this->setModel();
        if ( $this->class == 'Meditate' ) {
            $this->model->setSaved( $this->saved );
            $this->setView();
            $this->setTemplate();
            $this->respond();
        }
    }
    
	/*
	 * Set the content
	 */
	public function setClass()
	{
        if ( $this->isAjaxRequest() ) {
            $this->class = 'AjaxRequest';
            return;
        }
        
        if ( $this->canSaveMeditation() ) {
            $m = new SaveMeditation;
            if ( $m->save() ) {
                $this->saved = true;
            }
        }
        
    	$this->class = 'Meditate';
	}
    
    /*
     * Test if this is an ajax request
     */
    private function isAjaxRequest()
    {
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' && ! isset( $_POST['submit'] ) ) {
            return true;
        }
        return false;
    }
    
    /*
     * Test if there is are meditations stored in the session and the user is logged in
     */
    private function canSaveMeditation()
    {
        $user = User::getInstance();
        if ( ! $user->isSignedIn() ) {
            return false;
        }
        
        $session = Session::getInstance();
        if ( $session->get('meditation') == null ) {
            return false;
        }
        
        return true;
    }
	
	/*
	 * Return the request
	 */
	public function respond()
	{
		$this->template->setGuid( $this->request['guid'] );
		$this->template->setTitle( 'Meditation Timer' );
        $this->template->setScript( 'utilities.js' );
        $this->template->setScript( 'meditate.js' );
		$this->template->setContent( $this->view->getContent() );
	
		echo $this->template->request();
	}
}