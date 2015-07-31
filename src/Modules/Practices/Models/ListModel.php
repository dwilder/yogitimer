<?php
namespace Src\Modules\Practices\Models;

use Src\Includes\SuperClasses\Model;
use Src\Includes\Data\MeditationPractices;
use Src\Includes\Data\MeditationRecords;
use Src\Includes\Session\SessionMessage;

class ListModel extends Model
{
    /*
     * Objects
     */
    protected $meditation_practices;
    protected $meditation_records;
    
    /*
     * Run
     */
    public function run()
    {
        $this->setObject( new MeditationPractices, 'meditation_practices' );
        $this->setObject( new MeditationRecords, 'meditation_records' );
        
        $this->setSessionMessage();
    }
    
    /*
     * Set objects
     */
    protected function setObject( $object, $name )
    {
        $this->$name = $object;
        $this->$name->read();
        
        $this->data[$name] = $this->$name;
    }
    
    /*
     * Check for a session message
     */
    protected function setSessionMessage()
    {
        $this->data['session_message'] = array();
        
        $this->session_message = new SessionMessage;
        
        if ( $this->session_message->retrieve() ) {
            if ( $this->session_message->getDestination() == $this->request['guid'] ) {
                $meta = $this->session_message->getMeta();
                $this->data['session_message'] = array(
                    'success' => $meta['success'],
                    'message' => $this->session_message->getMessage()
                );
                
                $this->session_message->delete();
            }
        }
    }
}
