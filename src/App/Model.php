<?php
namespace Src\Program;

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
	 * An array of guids with corresponding modules
	 */
	private $modules = array(
		'signup' => 'SignUp',
		'activate' => 'SignUp',
		'login' => 'Login',
		'forgotpassword' => 'Login',
		'resetpassword' => 'Login',
		'logout' => 'Logout',
		'meditate' => 'Meditate',
		'profile' => 'Profile',
		'journal' => 'Journal',
		'settings' => 'Settings',
		'admin' => 'Admin'
	);
	
	/*
	 * Return the module
	 */
	public function getModule( $guid )
	{
		if ( $guid == null ) {
			return 'Index';
		}
		
		if ( array_key_exists( $guid, $this->modules ) ) {
			return $this->modules[$guid];
		}
		
		return 'Content';
	}
}