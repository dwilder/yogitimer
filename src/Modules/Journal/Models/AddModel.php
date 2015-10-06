<?php
namespace Src\Modules\Journal\Models;

use Src\Includes\SuperClasses\Model;
use Src\Includes\Data\MeditationRecord;
use Src\Includes\Data\MeditationPractices;
use Src\Modules\Journal\Helpers\tSetSubmittedData;

class AddModel extends Model
{   
    use tSetSubmittedData;
    
    /*
     * Store the record
     */
    protected $record;
    protected $practices;
    
    /*
     * Store an error
     */
    protected $error = false;
    
    /*
     * Run
     */
    public function run()
    {   
        $this->setPractices();
        
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $this->record = new MeditationRecord;
            $this->processRequest();
        }
        $this->setDefaults();
    }
    
    /*
     * Set practices
     */
    protected function setPractices()
    {
        $this->practices = new MeditationPractices;
        $this->practices->read();
        $this->data['practices'] = $this->practices;
    }
    
    /*
     * Attempt to add the meditation
     */
    protected function processRequest()
    {
        $this->setSubmittedData();
        
        if ( $this->error ) {
            return;
        }
        
        if ( ! $this->record->create() ) {
            $this->error = true;
            $this->data['error']['form'] = 'An error occurred while adding your meditation. Please try again.';
            return;
        }
    
        // Success!!
        $this->redirect('journal/edit/' . $this->record->get('id'));
    }
    
    /*
     * Set default date and time
     */
    protected function setDefaults()
    {
        $time = time() - (60 * 60);
        if ( ! isset( $this->data['date'] ) ) {
            $this->data['date'] = date('d m Y', $time);
        }
        if ( ! isset( $this->data['time'] ) ) {
            $this->data['time'] = date('g:i a', $time);
        }
        if ( ! isset( $this->data['practice'] ) ) {
            $this->data['practice'] = 0;
        }
    }
}
