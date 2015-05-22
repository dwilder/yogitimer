<?php
namespace Src\Lib\Session;

class Session
{
	/*
	 * Store the session handler
	 */
	private $sh;
	
	/*
	 * Store the session data
	 */
	protected $session_id;
	protected $user_agent;
	protected $data;
	protected $date_accessed;
	
	/*
	 * Store the PDO
	 */
	protected $pdo;
	
	/*
	 * Set the PDO
	 */
	public function setPDO( PDO $pdo )
	{
		$this->pdo = $pdo;
	}
	
	/*
	 * Start a session
	 */
	public function start()
	{
		$this->sh = new SessionHandler();
		$this->sh->setPDO( $this->pdo );
		session_set_save_handler( $this->sh, true );
		
		session_start();
	}
	
	/*
	 * Destroy a session
	 */
	public function end()
	{
		$this->sh->destroy( $this->session_id );
	}
}