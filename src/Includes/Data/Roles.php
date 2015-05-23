<?php
namespace Src\Includes\Data;

/*
 * The sole purpose of this class is define the available user roles
 */

class Roles
{
    /*
     * Available user roles
     */
    private $roles = array(
        'admin' => 'Administrator',
        'meditator' => 'Meditator'
    );
    
    /*
     * Return the array of available roles
     */
    public function getRoles()
    {
        return $this->roles;
    }
    
    /*
     * New user role
     */
    public function getNewUserRole()
    {
        return 'meditator';
    }
}
