<?php
namespace Src\App;

/*
 * Class to model the modules in the system.
 *
 * Returns the module to call based on a guid.
 * Returns Index if guid is null.
 * Returns CMS if guid is not found.
 */

class Model
{
	/*
	 * An array of guids with corresponding modules and access rules
	 */
	private $modules = array(
        'index' => array(
            'module' => 'Index',
            'login_state' => 'all',
            'ssl' => false
        ),
//        'contact' => array(
//            'module' => 'Contact',
//            'login_state' => 'all',
//            'ssl' => false
//        ),
		'signup' => array(
            'module' => 'SignUp',
            'login_state' => 'anonymous',
            'ssl' => true
        ),
		'activate' => array(
            'module' => 'SignUp',
            'login_state' => 'anonymous',
            'ssl' => true
        ),
		'login' => array(
            'module' => 'Login',
            'login_state' => 'anonymous',
            'ssl' => true
        ),
        'forgotpassword' => array(
            'module' => 'Login',
            'login_state' => 'anonymous',
            'ssl' => true
        ),
		'resetpassword' => array(
            'module' => 'Login',
            'login_state' => 'anonymous',
            'ssl' => true
        ),
		'logout' => array(
            'module' => 'Logout',
            'login_state' => 'authenticated',
            'ssl' => true
        ),
		'meditate' => array(
            'module' => 'Meditate',
            'login_state' => 'all',
            'ssl' => false
        ),
		'profile' => array(
            'module' => 'Profile',
            'login_state' => 'authenticate',
            'ssl' => false
        ),
		'journal' => array(
            'module' => 'Journal',
            'login_state' => 'authenticated',
            'ssl' => false
        ),
		'settings' => array(
            'module' => 'Settings',
            'login_state' => 'authenticated',
            'ssl' => true
        ),
//        'admin' => array(
//            'module' => 'Admin',
//            'login_state' => 'authenticated',
//            'ssl' => true
//        )
	);
	
    /*
     * Return an array for a specific module
     */
    public function getModuleData( $guid )
    {
        if ( array_key_exists( $guid, $this->modules ) ) {
            return $this->modules[$guid];
        }
        return array();
    }
    
	/*
	 * Return the module
	 */
	public function getModuleName( $guid = null )
	{
        $default = 'Index';
        
		if ( $guid == null ) {
			return $default;
		}
		
		if ( array_key_exists( $guid, $this->modules ) ) {
			return $this->modules[$guid]['module'];
		}
		
		return 'Content';
	}
}