<?php
namespace Src\Modules\Meditate;

use Src\Includes\Module\UIController;
use Src\Modules\Meditate\Models\MeditateModel;
use Src\Modules\Meditate\Views\MeditateView;

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
	 * Store model and view objects
	 */
	private $model;
	private $view;
	
	/*
	 * Set the content
	 */
	public function setContent()
	{
		$this->model = new MeditateModel;
		$this->view = new MeditateView;
	}
	
	/*
	 * Return the request
	 */
	public function request()
	{
		$this->setContent();
		
		$this->setTemplate();
		$this->template->setGuid( $this->guid );
		$this->template->setTitle( 'Meditation Timer' );
		$this->template->setContent( $this->view->getContent() );
		
		return $this->template->request();	
	}
    
    /*
     * Set the module name
     */
    protected function setModuleName()
    {
        $this->module_name = 'Meditate';
    }
}