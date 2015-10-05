<?php
namespace Src\Modules\Index\Models;

class MeditateActionModel
{
    private $text;
    private $subtext;
    private $url;
    private $class_suffix;
    
    public function __construct()
    {
        $this->text         = 'Meditate Now';
        $this->subtext      = 'Yogi Timer is free!';
        $this->url          = 'meditate';
        $this->class_suffix = 'meditate';
    }
    
    public function get( $data )
    {
        return $this->$data;
    }
}
