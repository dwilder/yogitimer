<?php
namespace Src\Modules\Journal\Views;

use Src\Modules\Journal\Helpers\tNotFound;

class EditView extends AbstractActionForm
{
    use tNotFound;
    
	/*
	 * Define the title
	 */
	protected $title = 'Edit Meditation Time';
    
    /*
     * Check the status
     */
    protected function checkStatus()
    {
        
    }
}