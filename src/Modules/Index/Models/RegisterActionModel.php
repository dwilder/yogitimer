<?php
namespace Src\Modules\Index\Models;

class RegisterActionModel
{
    private $text;
    private $subtext;
    private $url;
    private $class_suffix;
    
    public function __construct()
    {
        $this->text         = 'Create an Account';
        $this->subtext      = 'Yogi Timer is free!';
        $this->url          = 'register';
        $this->class_suffix = 'register';
    }
    
    public function get( $data )
    {
        return $this->$data;
    }
}
