<?php
namespace Src\App;

use Src\App\GuidParser;
use Src\App\Model;
use Src\Modules\Admin\Controller as Admin;
use Src\Modules\Content\Controller as Content;
use Src\Modules\Index\Controller as Index;
use Src\Modules\Journal\Controller as Journal;
use Src\Modules\Login\Controller as Login;
use Src\Modules\Logout\Controller as Logout;
use Src\Modules\Meditate\Controller as Meditate;
use Src\Modules\Profile\Controller as Profile;
use Src\Modules\Settings\Controller as Settings;
use Src\Modules\SignUp\Controller as SignUp;

/*
 * Top level controller
 *
 * Get session data
 * Get GET data
 * Get POST data
 * Determine the module to instantiate
 */
class Controller
{
	/*
	 * Store the guidparser
	 */
	private $guid_parser;
	
	/*
	 * Store a reference to config, PDO, session and user
	 */
    private $config;
	private $pdo;
	private $session;
	private $user;
	
	/*
	 * Store the program model
	 */
	private $model;
	
	/*
	 * Store the module controller
	 */
	private $module;
	
	/*
	 * Constructor creates the parser and model
	 */
	public function __construct()
	{
		$this->guid_parser = new GuidParser;
		$this->model = new Model;
	}
	
	/*
	 * Set the PDO instance
	 */
	public function setConfig( \Src\Config\Config $config )
	{
		$this->config = $config;
	}
	
	/*
	 * Set the PDO instance
	 */
	public function setPDO( \PDO $pdo )
	{
		$this->pdo = $pdo;
	}
	
    /*
     * Set the session
     */
    public function setSession( \Src\Includes\Session\Session $session )
    {
        $this->session = $session;
    }
	
    /*
     * Set the User
     */
    public function setUser( \Src\Includes\User\User $user )
    {
        $this->user = $user;
    }
	
	/*
	 * Run
	 */
	public function run()
	{
		$guid = $this->guid_parser->getGuid();
		$module = $this->model->getModule( $guid );
		$this->setModule( $module );
		$response = $this->module->request();
		
		echo $response;
		
		$this->close();
	}
	
	/*
	 * Instantiate the module controller
	 */
	private function setModule( $module )
	{
		$mod = '\Src\Modules\\' . $module . '\Controller';
		$this->module = new $mod;

		$this->module->setGuid( $this->guid_parser->getGuid() );
		$this->module->setPDO( $this->pdo );
	}
	
	/*
	 * Close the PDO connection and session
	 */
	private function close()
	{
		
	}
		 
}
