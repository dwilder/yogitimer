<?php
namespace Src\App;
	
use Src\Config\Config;
use Src\Includes\User\User;
use Src\Includes\Session\Session;
use Src\Includes\User\User;

require 'Autoload.php';
	
/*
 * Class to initialize generic components.
 * - Autoload
 * - Error
 * - Configuration
 * - PDO
 * - Return the configuration
 */
class Initialize
{
	/*
	 * Hold the configuration until finished initialization
	 */
	private $config;
	
	public function __construct() {
		$this->registerAutoloader();
		$this->registerErrorHandler();
        $this->setConfig();
		$config = Config::getInstance();
		$this->setTimezone( $config->get( 'timezone' ));
		$this->setMemoryLimit( $config->get( 'memory_limit' ));
		$this->setEmailAddress( $config->get( 'siteemail' ));
	}
	
	private function registerAutoloader()
	{
		new Autoload();
	}
	
	private function registerErrorHandler()
	{
		
	}
	
	private function setConfig()
	{
		$this->config = Config::getInstance();
	}
	
	public function getConfig()
	{
		return $this->config;
	}
	
	public function getPDO()
	{
		$dsn = 'mysql:dbname=' . $this->config->get( 'dbname' ) . ';';
		$dsn .=  'host=' . $this->config->get( 'host' );
		
		$user = $this->config->get( 'dbuser' );
		$password = $this->config->get( 'dbpass' );
		try {
			return new \PDO( $dsn, $user, $password );
		}
		catch (\PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
			exit;
		}
	}
	
	public function setTimezone( $timezone )
	{
		date_default_timezone_set( $timezone );
	}
	
	public function setMemoryLimit( $memory = null )
	{
		if ( $memory ) {
			ini_set( 'memory_limit', $memory );
		}
	}
    
	public function setEmailAddress( $email )
	{
		ini_set( 'sendmail_from', $email );
	}
	
	public function getSession()
	{
		// Instantiate a new session object
		$session = Session::getInstance();
		$session->start();
		
		// Return the session
		return $session;
	}
	
	public function getUser( \PDO $pdo, Session $session )
	{
		// Instantiate and return a User object
		$user = User::getInstance();
		$user->setPDO( $pdo );
		
		if ( $session->get( 'user_id' ) ) {
			$user->set( 'id', $session->get( 'user_id' ) );
			$user->read();
		}
		
		return $user;
	}
	
	public function getController()
	{
		return new Controller();
	}
}
?>