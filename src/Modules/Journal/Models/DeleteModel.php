<?php
namespace Src\Modules\Journal\Models;

use Src\Lib\Module\Model;
use Src\Modules\Journal\Helpers\tSetRecord;

class DeleteModel extends Model
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
        if ( ! $this->record->delete() ) {
            $this->error = true;
            $this->data['error']['form'] = 'An error occurred while deleting your meditation. Please try again.';
            return;
        }
    
        // Success!!
        $this->redirect( '/journal/restore/' . $this->record->get('id') );
    }
}
