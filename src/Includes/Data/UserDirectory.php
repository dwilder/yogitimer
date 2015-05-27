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
     * Constructor
     */
    
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
            $random = $random_hash->set();
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
        
        $base_dir = '../' . $config->get('upload_dir') . '/users/' . $this->value;
        
        if ( mkdir( $base_dir, 0757, true ) ) {
            return true;
        }
        return false;
    }
    
}
