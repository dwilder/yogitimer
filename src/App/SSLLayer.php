<?php
namespace Src\App;

use Src\Config\Config;

/*
 * Redirect to SSL or non-SSL as needed
 */
class SSLLayer
{
    /*
     * Store the SSL requirement
     */
    private $ssl;
    
    /*
     * The url
     */
    private $url;
    
    /*
     * Set the SSL requirement
     */
    public function setSSL( $ssl )
    {
        $this->ssl = $ssl;
    }
    
    /*
     * Run
     */
    public function run()
    {
        if ( ! $this->ssl && $this->isSSL() ) {
            $this->setUrl('http');
            $this->redirect();
        }

        $config = Config::getInstance();
        
        if ( $config->get('live') ) {
            if ( $this->ssl && ! $this->isSSL() ) {
                $this->setUrl('https');
                $this->redirect();
            }
        }
    }
    
    /*
     * Build URL
     */
    private function setUrl( $protocol )
    {
        $this->url = $protocol . "://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    
    /*
     * Test if the URL is SSL or not
     */
    private function isSSL()
    {
        if ( ! isset( $_SERVER['HTTPS'] ) ) {
            return false;
        }
        return true;
    }
    
    /*
     * Redirect
     */
    private function redirect()
    {
        header('Location: ' . $this->url);
        exit;
    }
}
