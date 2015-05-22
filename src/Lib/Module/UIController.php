<?php
namespace Src\Lib\Module;

use Src\Lib\Module\ControllerInterface;
use Src\Lib\Template\Controller as Template;
use Src\Lib\User\User;
use Src\Lib\Session\Session;
use Src\Config\Config;

/*
 * Abstract class for module UI controllers
 */
abstract class UIController implements ControllerInterface
{
	/*
     * Does the user need to be authenticated to view all UIs
     */
    protected $authenticated = false;
    
    /*
     * Store the module name
     */
    protected $module_name;
	
	/*
	 * Store the guid
	 */
	protected $guid;
    
	/*
	 * Store PDO
	 */
	protected $pdo;
	
	/*
	 * Store page content
	 */
	protected $content;
	
	/*
	 * Store the templating engine
	 */
	protected $template;
	
	/*
	 * Set the template engine
	 */
	protected function setTemplate()
	{
		$this->template = new Template;
	}
	
	/*
	 * Return UI
	 */
	public function request()
	{
        $this->testAuthentication();
        
        $this->setModuleName();
		$this->setContent();
        
		$this->setTemplate();
		$this->template->setGuid( $this->guid );
		$this->template->setContent( $this->content );
		return $this->template->request();
	}
	
	/*
	 * Set the guid
	 */
	public function setGuid( $guid )
	{
		$this->guid = $guid;
	}
	
	/*
	 * Set the PDO object reference
	 */
	public function setPDO( \PDO $pdo )
	{
		$this->pdo = $pdo;
	}
    
	/*
	 * Set the content
	 */
	public function setContent( $content = null ) {
		$this->content = $content;
	}
    
    /*
     * Test user authentication if required
     */
    protected function testAuthentication()
    {
        if ( $this->authenticated ) {
            $user = User::getInstance();
            if ( ! $user->isSignedIn() ) {
                $this->redirect('/login');
            }
        }
    }
    
    /*
     * Redirect function
     */
    protected function redirect( $url = '/' )
    {
        header('Location: ' . $url );
        exit;
    }
    
    /*
     * Set the module name
     */
    abstract protected function setModuleName();
			
}