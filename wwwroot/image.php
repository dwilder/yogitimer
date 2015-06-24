<?php
/*
 * A class responsible for retrieving uploaded images
 */
require '../src/Config/Config.php';

class Image
{
    /*
     * Store data
     */
    private $type = null;
    private $dir = null;
    private $file = null;
    private $filetype = null;
    
    /*
     * Path to the file
     */
    private $path;
    
    /*
     * Constructor
     */
    public function __construct()
    {
        $this->setType();
        $this->setDir();
        $this->setFile();
        
        $this->setPath();
        
        if ( ! $this->setFileType() ) {
            return;
        }
        
        if ( file_exists( $this->path ) && is_file( $this->path ) ) {
            $this->sendFile();
        }
    }
    
    /*
     * Set the image
     */
    private function setType()
    {
        if ( isset( $_GET['type'] ) ) {
            switch ( $_GET['type'] ) {
                case 'users':
                    $this->type = 'users';
                    break;
                case 'content':
                default:
                    $this->type = 'content';
                    break;
            }
        }
    }
    
    /*
     * Set the directory
     */
    private function setDir()
    {
        if ( isset( $_GET['dir'] ) ) {
            $this->dir = preg_replace( '/[^a-zA-Z0-9]/', '', $_GET['dir'] );
        }
    }
    
    /*
     * Set the filename
     */
    private function setFile()
    {
        if ( ! isset( $_GET['file'] ) ) {
            return;
        }
        $this->file = preg_replace( '/[^a-zA-Z0-9._-]/', '', $_GET['file'] );
    }
    
    /*
     * Set the path to the file
     */
    private function setPath()
    {
        $config = Src\Config\Config::getInstance();
        
        $this->path = '../' . $config->get('upload_dir');
        $this->path .= '/' . $this->type;
        if ( $this->dir ) $this->path .= '/' . $this->dir;
        $this->path .= '/' . $this->file;
    }
    
    /*
     * Validate the file type
     */
    protected function setFileType()
    {
        $allowed = array( 'png', 'jpg', 'jpeg', 'bmp', 'gif' );
        $this->filetype = strtolower( pathinfo( $this->path, PATHINFO_EXTENSION ) );
        if ( ! in_array( $this->filetype, $allowed ) ) {
            return false;
        }
        return true;
    }
    
    /*
     * Send the file
     */
    private function sendFile()
    {

    	// Get the image information:
    	$info = getimagesize($this->path);
    	$fs = filesize($this->path);

    	// Send the content information:
    	header ("Content-Type: $this->filetype\n");
    	header ("Content-Disposition: inline; filename=\"$this->filename\"\n");
    	header ("Content-Length: $fs\n");

    	// Send the file:
    	readfile ($this->path);
    }
}

(new Image());
