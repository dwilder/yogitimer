<?php
namespace Src\App;

class HttpRequest
{
	/*
	 * Store the request array
	 */
	private $request = array();
	
	/*
	 * Constructor sets the guid
	 */
	public function __construct()
	{
        $this->setProtocol();
		$this->processRequest();
	}
    
    /*
     * Check for and return a query element
     */
    public function getQueryValue( $key )
    {
        if ( isset( $this->request[$key] ) ) {
            return $this->request[$key];
        }
        return null;
    }
	
    /*
     * Set the protocol ( http / https )
     */
    private function setProtocol()
    {
        if ( empty( $_SERVER['HTTPS'] ) || $_SERVER['HTTPS'] == 'off' ) {
            $this->request['protocol'] = 'http';
            return;
        }
        $this->request['protocol'] = 'https';
    }
    
	/*
	 * Process the query string
	 */
	private function processRequest()
	{
        if ( ! $_SERVER['QUERY_STRING'] ) {
            return;
        }
		
        $query = explode( '/', $_SERVER['QUERY_STRING'] );
        
        $this->request = array_merge( $this->request, $query );
	}
	
	/*
	 * Return the request array
	 */
	public function getRequest()
	{
		return $this->request;
	}
}
