<?php
namespace Src\Includes\Data;

use Src\Includes\Session\Session;

class StoredMeditation
{
    /*
     * Test for a stored meditation
     */
    public function isStored()
    {
        $session = Session::getInstance();
        
        if ( $session->get('meditation') ) {
            return true;
        }
        return false;
    }
    
    /*
     * Redirect to save
     */
    public function save()
    {
        header('Location: /meditate' );
        exit;
    }
}
