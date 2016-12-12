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
	private $dbname = '';
	private $dbuser = '';
	private $dbpass = '';
	private $dbchar = 'utf8';
	
	/*
	 * Environment variables
	 */
    private $live = false;
	private $environment = 'dev';		// dev, stage, demo, live
	private $memory_limit = '128M';
    private $timezone = 'US/Eastern';

	/*
	 * System settings
	 */
	private $url = 'example.com';
	private $sitename = 'Yogi Timer';
    private $siteemail = 'email@example.com';
    
    /*
     * Directories
     */
    private $root_dir = '../src';
    private $upload_dir = 'uploads_yogitimer';
    
    /*
     * Stripe keys
     */
    private $stripe_private_key = null;
    private $stripe_public_key = null;

    /*
     * Config instance
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
     * Initialize configuration
     */
    public function init()
    {
        date_default_timezone_set($this->timezone);
    }
    
    /*
     * Getter
     */
    public function get( $key )
    {
        if ( $this->$key ) {
            return $this->$key;
        }
        return null;
    }
}
