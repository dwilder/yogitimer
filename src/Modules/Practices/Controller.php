<?php
namespace Src\Modules\Practices;

use Src\Includes\SuperClasses\UIController;

class Controller extends UIController
{
    /*
     * Set the class
     */
    protected function setClass()
    {
		if ( isset( $this->request['action'] ) ) {
			switch ( $this->request['action'] ) {
				case 'edit':
					$class = 'Edit';
					break;
				//case 'delete':
				//	$class = 'Delete';
				//	break;
				//case 'restore':
				//	$class = 'Restore';
				//	break;
				case 'add':
					$class = 'Add';
					break;
				default:
					$class = 'List';
					break;
			}
		} else {
		    $class = 'List';
		}
        $this->class = $class;
    }
}
