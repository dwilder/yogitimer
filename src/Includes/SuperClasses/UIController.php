<?php
namespace Src\Includes\SuperClasses;

use Src\Includes\Template\Controller as Template;

/*
 * Abstract class for module UI controllers
 */
abstract class UIController extends AbstractController
{	
	/*
	 * Store model, view, template
	 */
    protected $class;
	protected $model;
	protected $view;
	protected $template;
    /*
     * Run
     */
    public function run()
    {
        $this->setClass();
        $this->setModel();
        $this->setView();
        $this->setTemplate();
        $this->respond();
    }
    
    /*
     * Set the class name for the model and view
     */
    protected function setClass() {}
    
    /*
     * Set the model(s)
     */
    protected function setModel()
    {
        $class = 'Src\Modules\\' . $this->parameters['module'] . '\Models\\' . $this->class . 'Model';
        
        $this->model = new $class;
        $this->model->setRequest( $this->request );
        $this->model->run();
    }
    
    /*
     * Set the view
     */
    protected function setView()
    {
        $class = 'Src\Modules\\' . $this->parameters['module'] . '\Views\\' . $this->class . 'View';
        
        $this->view = new $class;
        $this->view->setData( $this->model->getData() );
        $this->view->run();
    }
    
	/*
	 * Set the template engine
	 */
	protected function setTemplate()
	{
		$this->template = new Template;
	}
	
	/*
	 * Return UI
	 */
	protected function respond()
	{
        if ( isset( $this->request['guid'] ) ) {
    		$this->template->setGuid( $this->request['guid'] );
        }
		$this->template->setContent( $this->view->getContent() );
		echo $this->template->request();
	}
}