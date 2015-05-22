<?php
namespace Src\Modules\Settings;

use Src\Lib\Module\UIController;

/*
 * Controller class for the user settings section.
 *
 * - Personal Settings
 * - Delete Account
 * - Profile Images
 * - Change Password
 */

class Controller extends UIController
{
	/*
	 * Store the view
	 */
	protected $view;
	
	/*
	 * Store the model
	 */
	protected $model;
	
	/*
	 * Store the action
	 */
	protected $action = null;
	
	/*
	 * Store the content
	 */
	protected $content;
	
	/*
	 * Set the content
	 */
	public function setContent()
	{
		$this->setAction();
		$this->setModel();
		$this->setView();
		
		$this->content = $this->view->getContent();
	}
	
	/*
	 * Check for an action
	 */
	protected function setAction()
	{
		if ( isset( $_GET['action'] ) ) {
			switch ( $_GET['action'] ) {
				case 'delete':
					$this->action = 'delete';
					break;
				case 'images':
					$this->action = 'images';
					break;
				case 'password':
					$this->action = 'password';
					break;
				default:
					$this->action = null;
					break;
			}
		}
	}
	
	/*
	 * Set the model
	 */
	protected function setModel()
	{
		switch ( $this->action ) {
			case 'delete':
				$model = 'Delete';
				break;
			case 'images':
				$model = 'Images';
				break;
			case 'password':
				$model = 'Password';
				break;
			default:
				$model = 'Settings';
				break;
		}
		
		$model = 'Src\Modules\Settings\Models\\' . $model . 'Model';
		$this->model = new $model;
	}
	
	/*
	 * Set the view
	 */
	protected function setView()
	{
		switch ( $this->action ) {
			case 'delete':
				$view = 'Delete';
				break;
			case 'images':
				$view = 'Images';
				break;
			case 'password':
				$view = 'Password';
				break;
			default:
				$view = 'Settings';
				break;
		}
		
		$view = 'Src\Modules\Settings\Views\\' . $view . 'View';
		$this->view = new $view;
		
		$this->view->setData( $this->model->getData() );
	}
	
}