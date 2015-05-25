<?php
namespace Src\Includes\SuperClasses;

abstract class Model
{
    /*
     * Store the request
     */
    protected $request = array();
    
    /*
     * Store data
     */
    protected $data = array();
    
    /*
     * Set the request
     */
    public function setRequest( $request = array() )
    {
        $this->request = $request;
    }
    
    /*
     * Return data
     */
    public function getData()
    {
        return $this->data;
    }
    
    /*
     * Run
     */
    abstract public function run();
    
    /*
     * Redirect
     */
    protected function redirect( $url )
    {
        $location = '/' . $url;
        header('Location: ' . $location);
        exit;
    }
}

