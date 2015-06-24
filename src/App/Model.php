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
     * Store the guid
     */
    private $guid = null;
    
    /*
     * Store the module
     */
    private $module = null;
    
	/*
	 * An array of guids with corresponding modules and access rules
	 */
	private $modules = array(
        'index' => array(
            'module' => 'Index',
            'login_access' => 'all',
            'ssl' => false
        ),
//        'contact' => array(
//            'module' => 'Contact',
//            'login_access' => 'all',
//            'ssl' => false
//        ),
		'signup' => array(
            'module' => 'SignUp',
            'login_access' => 'variable',
            'ssl' => true
        ),
		'activate' => array(
            'module' => 'SignUp',
            'login_access' => 'all',
            'ssl' => true
        ),
		'login' => array(
            'module' => 'Login',
            'login_access' => 'anonymous',
            'ssl' => true
        ),
        'forgotpassword' => array(
            'module' => 'Login',
            'login_access' => 'anonymous',
            'ssl' => true
        ),
		'resetpassword' => array(
            'module' => 'Login',
            'login_access' => 'all',
            'ssl' => true
        ),
		'logout' => array(
            'module' => 'Logout',
            'login_access' => 'authenticated',
            'ssl' => true
        ),
		'meditate' => array(
            'module' => 'Meditate',
            'login_access' => 'all',
            'ssl' => false
        ),
		'profile' => array(
            'module' => 'Profile',
            'login_access' => 'authenticated',
            'ssl' => false
        ),
		'journal' => array(
            'module' => 'Journal',
            'login_access' => 'authenticated',
            'ssl' => false
        ),
		'settings' => array(
            'module' => 'Settings',
            'login_access' => 'authenticated',
            'ssl' => true
        ),
        'default' => array(
            'module' => 'Content',
            'login_access' => 'all',
            'ssl' => false
        )
	);
    
    /*
     * Set guid
     */
    public function setGuid( $guid = 'index' )
    {
		$this->guid = $guid;
    }
    
    /*
     * Set the module
     */
    private function setModule()
    {
        if ( $this->module ) {
            return;
        }
        
        $default = 'index';
        
		if ( $this->guid == null ) {
			$this->module = $default;
            return;
		}
		
		if ( array_key_exists( $this->guid, $this->modules ) ) {
			$this->module = $this->guid;
            return;
		}
		
		$this->module = 'default';
    }
	
    /*
     * Return an array for a specific module
     */
    public function getData()
    {
        return $this->getModuleData();
    }
    
    /*
     * Return the authentication requirement
     */
    public function getLoginAccess()
    {
        return $this->getModuleData('login_access');
    }
    
	/*
	 * Return the module name
	 */
	public function getModule()
	{
        return $this->getModuleData('module');
	}
    
	/*
	 * Return the module name
	 */
	public function getSSL()
	{
        return $this->getModuleData('ssl');
	}
    
    /*
     * Get a module data element
     */
    private function getModuleData( $element = null )
    {
        if ( ! $this->module ) {
            $this->setModule();
        }
        
        if ( array_key_exists( $this->module, $this->modules ) ) {
            $module = $this->module;
        }
        else {
            $module = 'default';
        }
        
        if ( $element ) {
            return $this->modules[$module][$element];
        }
        else {
            return $this->modules[$module];
        }
    }
}