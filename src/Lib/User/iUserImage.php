<?php
namespace Src\Lib\User;

interface iUserImage
{   
    /*
     * CRUD Methods
     */
    public function create();
    public function read();
    public function update();
    public function delete();
    
    /*
     * Create HTML to display an image
     */
    public function getHtml();
    
}
