<?php
namespace Src\Lib\Module;

use Src\Lib\Module\UIController;

/*
 * Abstract class for module UI controllers
 */
abstract class MultiUIController extends UIController
{   
	/*
	 * Store the data model
	 */
	protected $model;
	
	/*
	 * Store the view
	 */
	protected $view;
	
	/*
	 * Process the request
	 */
	public function request()
	{
        $this->testAuthentication();
        
        $this->setModuleName();
		$this->setModel();
		$this->setView();
		
		$this->setTemplate();
		$this->template->setGuid( $this->guid );
		$this->template->setContent( $this->view->getContent() );
	
		return $this->template->request();	
	}
	
	/*
	 * Set the Model
	 */
	protected function setModel()
	{
		$class = $this->getClass();
        
		$model = 'Src\Modules\\' . $this->module_name . '\Models\\' . $class . 'Model';
        
		$this->model = new $model;
        $this->model->setPDO( $this->pdo );
        $this->model->run();
	}
	
	
	/*
	 * Create a View object for a specific action
	 */
	protected function setView()
	{
        $class = $this->getClass();

		$view = 'Src\Modules\\' . $this->module_name . '\Views\\' . $class . 'View';
        
        $this->view = new $view;
        $this->view->setData( $this->model->getData() );
	}
    
    /*
     * Return the required class
     */
    abstract protected function getClass();
    
			
}