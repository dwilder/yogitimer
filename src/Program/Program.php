<?php
namespace Src\Program;

require 'Initialize.php';
	
/* Create class to:	
 *	- Initialize the system
 *	- Get configuration
 *	- Run the application
 *	- Store the PDO connection
 *	- Store the User
 *	- Store the Http object
 */
class Program
{
	/*
	 * Initializer
	 */
	private $initialize;
	
	/*
	 * Configuration data
	 */
	private $config;
	
	/*
	 * Database connection
	 */
	private $pdo;
	
	/*
	 * Session (regenerate ID, close)
	 */
	private $session;
	
	/*
	 * Current user
	 */
	private $user;
	
	/*
	 * Top level controller
	 */
	private $controller;
	
	/*
	 * Timestamp
	 */
	private $timestamp;
	
	/*
	 * Constructor
	 */
	public function __construct()
	{
		$this->timestamp = microtime();
		$this->initialize();
		$this->run();
	}
	
	/*
	 * Run system configuration
	 */
	private function initialize()
	{
		$this->initialize	= new Initialize();
		$this->config		= $this->initialize->getConfig();
		$this->pdo			= $this->initialize->getPDO();
		$this->session      = $this->initialize->getSession();
		$this->user		    = $this->initialize->getUser( $this->pdo, $this->session );
		$this->controller	= $this->initialize->getController();
		
		$this->controller->setconfig( $this->config );
		$this->controller->setPDO( $this->pdo );
		$this->controller->setSession( $this->session );
		$this->controller->setUser( $this->user );
	}
	
	/*
	 * Run the program
	 */
	private function run()
	{
		$this->controller->run();
		
		if ( $this->config->get( 'environment') != 'live' ) {
			$this->report();
		}
	}
	
	/*
	 * Performance reporting
	 */
	private function report()
	{
		$report = "\n\n<!--\n";
		
		$report .= "\n | Run time: " . (microtime() - $this->timestamp );
		$report .= "\n | Memory: " . memory_get_peak_usage();
		$report .= "\n | " . $this->reportOnGET();
        $report .= "\n | " . $_SERVER['HTTP_REFERER'];
		
		$report .= "\n\n-->";
		
		echo $report;
	}
	
	/*
	 * Build the $_GET array report
	 */
	private function reportOnGET()
	{
		if ( !empty( $_GET ) ) {
			$get = '$_GET: ';
			foreach ( $_GET as $k => $v ) {
				$get .= $k . ' => ' . $v . ', ';
			}
			return trim( $get, ', ' );
		}
	}
}

(new Program());