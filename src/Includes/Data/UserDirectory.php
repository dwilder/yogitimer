<?php
namespace Src\Includes\Data;

use Src\Config\Config;
use Src\Includes\Data\AbstractDataValue;
use Src\Includes\Data\RandomHash;
use Src\Includes\Data\DatabaseValueTrait;

class UserDirectory extends AbstractDataValue
{
    use DatabaseValueTrait;
    
    /*
     * Store the random hash object
     */
    protected $random_hash;
    
    /*
     * Set
     */
    public function set() {}
        
    /*
     * Create a unique directory
     */
    public function create()
    {
        $this->createUniqueDirectoryName();
        $this->makeDirectory();
    }
    
    /*
     * Create a unique directory name
     */
    private function createUniqueDirectoryName()
    {
        $random_hash = new RandomHash;
        $random_hash->setLength('16');
        
        $unique = false;
        
        while ( $unique == false ) {
            $random_hash->set();
            $random = $random_hash->get();
            if ( $this->isUnique( 'users', 'directory', $random ) ) {
                $this->value = $random;
                $unique = true;
            }
        }
    }
    
    /*
     * Make the directory
     */
    private function makeDirectory()
    {
        $config = Config::getInstance();
        
        $dir = '../' . $config->get('upload_dir') . '/users/' . $this->value;
        
        if ( is_dir( $dir ) ) {
            return true;
        }
        
        if ( mkdir( $dir, 0757 ) ) {
            return true;
        }
        return false;
    }
    
}
