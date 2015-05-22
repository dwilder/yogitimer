<?php
namespace Src\Lib\Module;

abstract class Model
{
    /*
     * Store data
     */
    protected $data = array();
    
    /*
     * Store PDO
     */
    protected $pdo;
    
    /*
     * Return data
     */
    public function getData()
    {
        return $this->data;
    }
    
    /*
     * Set PDO
     */
    public function setPDO( \PDO $pdo )
    {
        $this->pdo = $pdo;
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
        header('Location: ' . $url);
        exit;
    }
}

