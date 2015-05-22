<?php
namespace Src\Modules\Logout;

use Src\Lib\Module\UIController;
use Src\Modules\Logout\Models\LogoutModel;

/*
 * Controller class for logging out.
 */

class Controller extends UIController
{
    /*
     * Run the program
     */
    public function request()
    {
        $this->model = new LogoutModel;
        $this->model->logout();
    }
    
    /*
     * Implement setModuleName
     */
    protected function setModuleName()
    {
        $this->module_name = 'Logout';
    }
    
}