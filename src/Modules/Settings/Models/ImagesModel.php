<?php
namespace Src\Modules\Settings\Models;

use Src\Includes\SuperClasses\Model;
use Src\Config\Config;
use Src\Includes\User\User;
use Src\Includes\Image\ImageUploader;
//use Src\Includes\User\UserImages;

class ImagesModel extends Model
{	
    /*
     * Image objects
     */
    protected $profile;
    protected $banner;
    
    /*
     * Store the user object
     */
    protected $user;
    
    /*
     * Upload directory
     */
    protected $dir;
    
	/*
	 * Set the data
	 */
	public function run()
	{
        $this->user = User::getInstance();
        
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $this->process();
        }
        $this->setUserImages();
	}
    
    /*
     * Process form submission
     */
    protected function process()
    {
        $this->setImage('profile');
        $this->setImage('banner');

        if ( ! $this->user->updateImages() ) {
            $this->data['error']['form'] = 'An error occurred. Please try again.';
            return;
        }
        
        $this->setUploadDirectory();

        $this->moveImage( 'profile' );
        $this->moveImage( 'banner' );

        $this->data['success'] = true;
    }
    
    /*
     * Set an image
     */
    protected function setImage( $type )
    {
        $this->$type = new ImageUploader($type);
        $this->$type->get('postname');
        $this->$type->setFile();

        if ( $this->$type->getError() ) {
            $this->data['error'][$type] = $this->$type->getError();
            return false;
        }
        
        if ( $this->$type->hasImage() ) {
            $this->user->setImage( $type, $this->$type->getFilename() );
        }
    }
    
    /*
     * Set the upload directory
     */
    protected function setUploadDirectory()
    {
        $config = Config::getInstance();
        $this->dir = '../' . $config->get('upload_dir') . '/users/' . $this->user->get('directory');
    }

    /*
     * Move images to the proper directory
     */
    protected function moveImage( $type )
    {
        if ( $this->$type->hasImage() ) {
            $this->$type->moveTo( $this->dir );
        }
    }

    /*
     * Set the image paths
     */
    private function setUserImages()
    {
        $this->data['profile'] = $this->user->getImage('profile');
        $this->data['banner'] = $this->user->getImage('banner');
    }
}