<?php
namespace Src\Modules\Journal\Models;

use Src\Includes\SuperClasses\Model;
use Src\Includes\Data\MeditationRecord;
use Src\Modules\Journal\Helpers\tSetSubmittedData;

class AddModel extends Model
{   
    use tSetSubmittedData;
    
    /*
     * Store the record
     */
    protected $record;
    
    /*
     * Run
     */
    public function run()
    {
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $this->record = new MeditationRecord;
            $this->processRequest();
        }
        $this->setDefaults();
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
        $this->redirect('/journal/edit/' . $this->record->get('id'));
    }
    
    /*
     * Set default date and time
     */
    protected function setDefaults()
    {
        $time = time() - (60 * 60);
        if ( ! $this->data['date'] ) {
            $this->data['date'] = date('d m Y', $time);
        }
        if ( ! $this->data['time'] ) {
            $this->data['time'] = date('g:i a', $time);
        }
    }
}
