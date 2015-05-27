<?php
namespace Src\Modules\Journal;

use Src\Includes\User\User;
use Src\Includes\SuperClasses\MultiUIController;
use Src\Modules\Journal\Models\ActionModel;
use Src\Modules\Journal\Views\JournalView;
use Src\Modules\Journal\Views\AddView;
use Src\Modules\Journal\Views\EditView;
use Src\Modules\Journal\Views\DeleteView;


/*
 * Controller class for the journal section.
 *
 * A user must be logged in to view their records.
 *
 * - Journal main page
 * - Add Meditation Time
 * - Edit Meditation Time
 * - Delete Meditation Time
 */

class Controller extends MultiUIController
{	
    /*
     * User must be authenticated
     */
    protected $authenticated = true;
    
	/*
	 * Store the meditation id if the action is edit or delete
	 */
	protected $mid = null;
    
    /*
     * Get the correct class name
     */
    protected function setClass()
    {
		if ( isset( $_GET['action'] ) ) {
			switch ( $_GET['action'] ) {
				case 'edit':
					$class = 'Edit';
					break;
				case 'delete':
					$class = 'Delete';
					break;
				case 'restore':
					$class = 'Restore';
					break;
				case 'add':
					$class = 'Add';
					break;
				default:
					$class = 'Journal';
					break;
			}
		} else {
		    $class = 'Journal';
		}
        $this->class = $class;
    }
}