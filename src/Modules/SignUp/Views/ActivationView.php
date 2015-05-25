<?php
namespace Src\Modules\SignUp\Views;

use Src\Includes\SuperClasses\View;
use Src\Includes\UIElements\LinkButton;

class ActivationView extends View
{
	/*
	 * Store the content
	 */
	protected $content = null;
    
    /*
     * Model data, status
     */
    private $status;
	
	/*
	 * Determine what content to display
	 */
	public function run()
	{
        $this->setStatus();
		switch( $this->status ) {
			case 'success':
				$this->setSuccessContent();
				break;
			case 'active':
				$this->setActiveContent();
				break;
			case 'failure':
			default:
				$this->setFailureContent();
				break;
		}
	}
    
    /*
     * Set the status based on the success or failure of the model
     */
    private function setStatus()
    {
        if ( isset( $this->data['success'] ) ) {
            $this->status = 'success';
        }
        elseif ( isset( $this->data['error'] ) && $this->data['error'] == 'ACTIVE ACCOUNT' ) {
            $this->status = 'active';
        }
        else {
            $this->status = 'failure';
        }
    }
	
	/*
	 * Set content if the activation was successful
	 */
	private function setSuccessContent()
	{
		$title = '<h1>Account Activated</h1>';
		
		//$content = '<p>Hi {username},</p>';
		$content = '<p>Hi,</p>';
		$content .= '<p>Your account has been activated. Your meditations will now be stored in your Journal.</p>';
		$content .= '<p>' . (new LinkButton( '/meditate', 'Start Meditating' )) . '</p>';
		$content .= '<p>Want to log previous meditations?</p>';
		$content .= '<p>' . (new LinkButton( '/journal', 'Add Meditation Times' )) . '</p>';
		
		$this->content = $title . $content;
	}
	
	/*
	 * Set content if the account is already active
	 */
	private function setActiveContent()
	{
		$title = '<h1>Already Active</h1>';
		
		$content = '<p>Your account has already been activated.</p>';
		$content .= '<p>' . (new LinkButton( '/login', 'Login' )) . '</p>';
		
		$this->content = $title . $content;
	}
	
	/*
	 * Set content if the activation failed
	 */
	private function setFailureContent()
	{
		$title = '<h1>Activation Failed</h1>';
		
		$content = '<p>Your account could not be activated. Please contact the administrator for help.</p>';
		$content .= '<p>' . (new LinkButton( '/contact', 'Get Help' )) . '</p>';
		
		$this->content = $title . $content;
	}
	
}
