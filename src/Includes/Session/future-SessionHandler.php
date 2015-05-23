<?php
namespace Src\Includes\Session;

/*
 * Sessions are stored in the database
 *
 * session id ( CHAR(32) )
 * user_agent ( md5($_SERVER['HTTP_USER_AGENT']) )
 * data (TEXT)
 * date_accessed ( TIMESTAMP )
 */

class SessionHandler implements SessionHandlerInterface
{
	/*
	 * Store PDO
	 */
	private $pdo;
	
	/*
	 * Store session id
	 */
	private $session_id;
	
	/*
	 * Store the user agent
	 */
	private $user_agent;
	
	/*
	 * Store a reference to PDO
	 */
	public function setPDO( \PDO $pdo )
	{
		$this->pdo = $pdo;
	}
	
	/*
	 * Set the session id
	 */
	private function createSessionId()
	{
		
	}
	
	/*
	 * Set the user agent
	 */
	private function setUserAgent()
	{
		$this->user_agent = md5($_SERVER['HTTP_USER_AGENT']);
	}
	
	/*
	 * Start the session
	 */
	public function open( $save_path, $session_name )
	{
		$this->setUserAgent();
		return true;
	}
	
	/*
	 * End the session
	 */
	public function close()
	{
		return true;
	}
	
	/*
	 * Read the session
	 */
	public function read( $session_id )
	{
		$q = 'SELECT data FROM sessions WHERE id=:id AND user_agent=:ua';
		$stmt = $this->pdo->prepare( $q );
		$stmt->bindParam( ':id', $session_id );
		$stmt->bindParam( ':us', $this->user_agent );
		
		$data = null;
		
		if ( $stmt->execute() ) {
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		
		return $data;
	}
	
	/*
	 * Write to the session
	 */
	public function write( $session_id, $session_data )
	{
		$q = 'REPLACE INTO sessions';
	}
	
	/*
	 * Destroy the session
	 */
	public function destroy( $session_id )
	{
		$q = "DELETE FROM sessions WHERE id=:id LIMIT 1";
		$stmt = $this->pdo->prepare( $q );
		$stmt->bindParam( ':id', $session_id );
	}
	
	/*
	 *
	 */
	public function gc( $maxlifetime )
	{
		
	}
}
