<?php
namespace Src\Includes\Email;

/*
 * This is a base class for sending email
 */
class AdminEmail extends Email
{
    /*
     * Store the site admin email as the $from variable
     */
    //protected $from;
    
    /*
     * Set the site admin email
     */
    public function setFrom( $email )
    {
        $this->from = 'Admin <' . $email . '>';
    }
}
