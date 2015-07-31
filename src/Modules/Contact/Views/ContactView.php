<?php
namespace Src\Modules\Contact\Views;

use Src\Includes\SuperClasses\View;
use Src\Includes\Form\Form;

class ContactView extends View
{
	/*
	 * Store the form
	 */
	protected $form;
	
    /*
     * Run
     */
    public function run()
    {
		$content = $this->getTitle();
		$content .= $this->getHelp();
        
        $content .= $this->getFormMessage();
		
		$this->form = new Form();
		$this->buildForm();
		$content .= $this->form->getHTML();
		//$content .= $this->getModal();
		
		$this->content = $content;
		return $content;
    }
	
	/*
	 * Get the title
	 */
	protected function getTitle()
	{
		return '<h1>Contact</h1>';
	}
	
	/*
	 * Get the write up
	 */
	protected function getHelp()
	{
		$html = '<p>';
		$html .= 'Please use the form below for all inquiries and support requests. I will respond within a reasonable timeframe.';
		$html .= '</p>';
		
		return $html;
	}
    
    /*
     * Add a "sent" or "error" message indicator
     */
    protected function getFormMessage()
    {
        if ( isset( $this->data['success'] ) ) {
            return '<p class="form-success">Your message has been sent.</p>';
        }
        if ( isset( $this->data['error']['form'] ) ) {
            return '<p class="form-error">' . $this->data['error']['form'] . '</p>';
        }
        elseif ( isset( $this->data['error'] ) && ! empty( $this->data['error'] ) ) {
            return '<p class="form-error">Please check for errors.</p>';
        }
        return '';
    }
    
	/*
	 * Create the form
	 */
	protected function buildForm()
	{
		$name = $this->form->newInput( 'text' );
		$name->setLabel( 'What is your name?' );
		$name->set( 'name', 'name' );
		$name->set( 'id', 'name' );
		( ! isset( $this->data['name'] ) ) || $name->set( 'value', $this->data['name'] );
		( ! isset( $this->data['error']['name'] ) ) || $name->setError( $this->data['error']['name'] );

		$email = $this->form->newInput( 'email' );
		$email->setLabel( 'What is your email address?' );
		$email->set( 'name', 'email' );
		$email->set( 'id', 'email' );
		( ! isset( $this->data['email'] ) ) || $email->set( 'value', $this->data['email'] );
		( ! isset( $this->data['error']['email'] ) ) || $email->setError( $this->data['error']['email'] );

		$message = $this->form->newInput( 'textarea' );
		$message->setLabel( 'Include your message:' );
		$message->set( 'name', 'message' );
		$message->set( 'id', 'message' );
		( ! isset( $this->data['message'] ) ) || $message->set( 'value', $this->data['message'] );
		( ! isset( $this->data['error']['message'] ) ) || $message->setError( $this->data['error']['message'] );
		
		$begin = $this->form->newInput( 'submit' );
		$begin->set( 'name', 'submit' );
		$begin->set( 'id', 'submit' );
		$begin->set( 'value', 'Send' );
    }
    
}
