<?php
namespace Src\App;

/*
 * Top level controller
 */
class Controller
{
	/*
	 * Store the HttpRequest object, app Model, and security layer
	 */
	private $http_request;
	private $model;
	
	/*
	 * Store the module controller
	 */
	private $module;
	
	/*
	 * Run
	 */
	public function run()
	{
        $this->setHttpRequest();
        $this->setAppModel();
        $this->checkSecurity();
        $this->checkSSL();
        
        $this->setModule();
        
//		$guid = $this->guid_parser->getGuid();
//		$module = $this->model->getModule( $guid );
//		$this->setModule( $module );
//		$response = $this->module->request();
		
//		echo $response;
		
		$this->close();
	}
    
    /*
     * Set the HTTP Request
     */
    private function setHttpRequest()
    {
        $this->http_request = new HttpRequest();
    }
    
    /*
     * Set the App Model
     */
    private function setAppModel()
    {
        $this->model = new Model;
        $this->model->setGuid( $this->http_request->getQueryValue('guid') );
    }
    
    /*
     * Check security
     */
    private function checkSecurity()
    {
        $security_layer = new SecurityLayer;
        $security_layer->setLoginAccess( $this->model->getLoginAccess() );
        $security_layer->run();
    }
    
    /*
     * Check SSL
     */
    private function checkSSL()
    {
        $ssl_layer = new SSLLayer;
        $ssl_layer->setSSL( $this->model->getSSL() );
        $ssl_layer->run();
    }
	
	/*
	 * Set and run the module
	 */
	private function setModule()
	{
        $module = $this->model->getModule();
        
		$class = '\Src\Modules\\' . $module . '\Controller';
		$this->module = new $class;

		$this->module->setRequest( $this->http_request->getRequest() );
        $this->module->run();
	}
}
