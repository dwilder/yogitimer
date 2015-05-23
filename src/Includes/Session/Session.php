<?php
namespace Src\Includes\Session;

/*
 * Singleton
 */

class Session
{
    /*
     * Store the instance
     */
    static private $instance = null;
    
	/*
	 * Store the session data
	 */
	protected $session_id;
	protected $user_agent;
	protected $data;
	protected $date_accessed;
	
    /*
     * Prevent multiple instances
     */
    private function __construct() {}
    private function __clone() {}
        
    /*
     * Get the instance
     */
    static public function getInstance()
    {
        if ( self::$instance == null ) {
            self::$instance = new Session();
        }
        return self::$instance;
    }
    
	/*
	 * Start a session
	 */
	public function start()
	{
		session_start();
	}
	
	/*
	 * Set a value in the session
	 */
	public function set( $key, $value = null )
	{
		$_SESSION[$key] = $value;
	}
	
	/*
	 * Get a value from the session
	 */
	public function get( $key )
	{
        if ( isset( $_SESSION[$key] ) ) {
            return $_SESSION[$key];
        }
		
        return null;
	}
	
	/*
	 * Regenerate the session id
	 */
	public function regenerate()
	{
		session_regenerate_id();
	}
	
	/*
	 * End a session
	 */
	public function end()
	{
		//$this->sh->destroy( $this->session_id );
	}
    
    /*
     * Destroy a session
     */
    public function destroy()
    {
        $_SESSION = array();
        session_destroy();
        setcookie( session_name(), '', time()-3600 );
    }
}