<?php
namespace Src\Modules\Journal\Models;

use Src\Includes\Module\Model;
use Src\Modules\Journal\Helpers\tSetRecord;
use Src\Modules\Journal\Helpers\tSetSubmittedData;

class EditModel extends Model
{
    use tSetRecord;
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
        $this->setRecord();
        $this->isRecordDeleted();
        
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $this->processRequest();
        }
    }
    
    /*
     * Test whether the record is deleted and redirect to restore
     */
    protected function isRecordDeleted() {
        if ( $this->record->isDeleted() ) {
            $this->redirect('/journal/restore/' . $this->record->get('id'));
        }
    }
    
    /*
     * Process the form submission
     */
    protected function processRequest()
    {
        $this->setSubmittedData();
        
        if ( $this->error ) {
            return;
        }
        
        if ( ! $this->record->update() ) {
            $this->error = true;
            $this->data['error']['form'] = 'An error occurred while updating your meditation. Please try again.';
            return;
        }
    
        // Success!!
        $this->data['status'] = 'SUCCESS';
    }
    
}
