<?php
namespace Src\Includes\SuperClasses;

abstract class AbstractController
{
    /*
     * Store the request and module parameters
     */
    protected $request = array();
    protected $parameters = array();
    
    /*
     * Set the request
     */
    public function setRequest( $request = array() )
    {
        $this->request = $request;
    }
    
    /*
     * Set the module data
     */
    public function setModuleParameters( $params = array() )
    {
        $this->parameters = $params;
    }
    
    /*
     * Run
     */
    abstract public function run();
    
    /*
     * Redirect
     */
    protected function redirect( $url = null )
    {
        $location = '/' . $url;
        header('Location: ' . $location);
        exit;
    }
}
