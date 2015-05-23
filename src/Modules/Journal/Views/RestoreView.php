<?php
namespace Src\Modules\Journal\Views;

use Src\Includes\Module\View;
use Src\Includes\Form\Form;
use Src\Modules\Journal\Helpers\tNotFound;

class RestoreView extends View
{
    use tNotFound;
    
    /*
     * Set the title
     */
    protected $title = "Deleted Meditation Time";
	
	/*
	 * Set the content
	 */
	protected function setContent()
	{
		if ( $this->notFound() ) {
		    $this->setNotFoundContent();
		}
        elseif ( $this->success() ) {
		    $this->setSuccessContent();
		}
        else {
            $this->setFormContent();
        }
	}
    
    /*
     * Check for success
     */
    protected function success()
    {
        if ( isset( $this->data['status'] ) && $this->data['status'] == 'SUCCESS' ) {
            return true;
        }
        return false;
    }
    
    /*
     * Set success content
     */
    protected function setSuccessContent()
    {
        $this->title = 'Meditation Restored';
        
        $content = $this->getTitle();
        $content .= "Your meditation time on <b>";
        $content .= $this->data['long_date'];
        $content .= "</b> has been restored.</p>";
        
        $content .= '<p><a href="/journal">Back to Journal</a></p>';
        
        $this->content = $content;
    }
    
    /*
     * Set OK content
     */
    protected function setFormContent()
    {
		$content = $this->getTitle();
		
		$content .= '<p>Your meditation time on <b>';
		$content .= $this->data['long_date'];
		$content .= '</b> has been deleted. Would you like to restore it?</p>';
		
		$this->Form = new Form;
		$this->buildForm();
		$content .= $this->Form->getHtml();
		
		// Add the cancel link
		$content .= $this->cancelLink();
		
		$this->content = $content;
    }
    
	/*
	 * Create the form
	 */
	protected function buildForm()
	{	
		$mid = $this->Form->newInput( 'hidden' );
		$mid->set( 'name', 'mid' );
		$mid->set( 'id', 'mid' );
		$mid->set( 'value', $this->data['id'] );
		
		$submit = $this->Form->newInput( 'submit' );
		$submit->set( 'name', 'submit' );
		$submit->set( 'id', 'submit' );
		$submit->set( 'value', 'Restore' );
	}
	
	/*
	 * Create a cancel link
	 */
	protected function cancelLink()
	{
		return '<p class="form-link-cancel"><a href="/journal">Back to Journal</a></p>';
	}
}
