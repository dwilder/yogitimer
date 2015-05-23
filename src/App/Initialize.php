<?php
namespace Src\App;
	
use Src\Config\Config;
use Src\Includes\Database\DB;
use Src\Includes\Session\Session;
use Src\Includes\User\User;

require 'Autoload.php';

class Initialize
{
	/*
	 * Store config, session
	 */
	private $config;
	private $session;
	
    /*
     * Run
     */
    public function run()
    {
        $this->setAutoload();
        $this->setErrorHandler();
        $this->setConfig();
        $this->setDB();
        $this->setSession();
        $this->setUser();
    }
	
	private function setAutoload()
	{
		new Autoload();
	}
	
	private function setErrorHandler()
	{
		new ErrorHandler();
	}
	
	private function setConfig()
	{
		$this->config = Config::getInstance();
        $this->config->init();
	}
	
	public function setDB()
	{
		$dsn = 'mysql:dbname=' . $this->config->get( 'dbname' ) . ';';
		$dsn .=  'host=' . $this->config->get( 'dbhost' );
		
		$user = $this->config->get( 'dbuser' );
		$password = $this->config->get( 'dbpass' );
		
        new DB( $dsn, $user, $password );
	}
	
	public function setSession()
	{
		// Instantiate a new session object
		$this->session = Session::getInstance();
		$this->session->start();
	}
	
	public function setUser()
	{
		// Instantiate and return a User object
		$user = User::getInstance();
		
		if ( $this->session->get( 'user_id' ) ) {
			$user->set( 'id', $session->get( 'user_id' ) );
			$user->read();
		}
	}
}
