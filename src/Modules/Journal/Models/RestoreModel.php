<?php
namespace Src\Modules\Journal\Models;

use Src\Lib\Module\Model;
use Src\Modules\Journal\Helpers\tSetRecord;

class RestoreModel extends Model
{
    use tSetRecord;
    
    /*
     * Store the record
     */
    protected $record;
    
    /*
     * Run
     */
    public function run()
    {
        $this->setRecord();
        $this->isRecordNotDeleted();
        
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $this->processRequest();
        }
    }
    
    /*
     * Test whether the record is deleted and redirect to restore
     */
    protected function isRecordNotDeleted() {
        if ( ! $this->record->isDeleted() ) {
            $this->data['status'] = 'SUCCESS';
        }
    }
    
    /*
     * Process the form submission
     */
    protected function processRequest()
    {
        if ( ! $this->record->restore() ) {
            $this->error = true;
            $this->data['error']['form'] = 'An error occurred while restoring your meditation. Please try again.';
            return;
        }
    
        // Success!!
        $this->data['status'] = 'SUCCESS';
    }
    
}
