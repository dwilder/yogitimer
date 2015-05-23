<?php
namespace Src\App;

use Src\App\Controller;

require 'Initialize.php';

class App
{
    /*
     * Store initialize, controller
     */
    private $initialize;
    private $controller;
    
    /*
     * Constructor. Run the program
     */
    public function __construct()
    {
        $this->initialize();
        $this->setController();
    }
    
    /*
     * Initialize
     */
    private function initialize()
    {
        $this->initialize = new Initialize;
        $this->initialize->run();
    }
    
    /*
     * Set the controller
     */
    private function setController()
    {
        $this->controller = new Controller;
        $this->controller->run();
    }
}