<?php
namespace Src\Config;
/*
 * A class to hold configuration data
 */

class Config
{
	/*
	 * Database configuration
	 */
	private $dbhost = 'localhost';
	private $dbname = 'meditate';
	private $dbuser = 'root';
	private $dbpass = 'root';
	private $dbchar = 'utf8';
	
	/*
	 * Environment variables
	 */
	private $environment = 'dev';		// dev, stage, demo, live
	private $memory_limit = '128M';

	/*
	 * System settings
	 */
	private $url = 'meditate.dev';
	private $sitename = 'Meditate';
    private $siteemail = 'meditate@davewilder.ca';
	private $timezone = 'America/Toronto';
	
    /*
     * Store a single instance of the class
     */
    static private $instance = null;
    
    /*
     * Prevent multiple instances
     */
    private function __construct() {}
    private function __clone() {}
        
    /*
     * Return itself
     */
    static function getInstance()
    {
        if ( self::$instance == null ) {
            self::$instance = new Config();
        }
        return self::$instance;
    }
    
	/*
	 * Method to return one of the arrays
	 */
	public function get( $property )
	{
		return $this->$property;
	}
}
