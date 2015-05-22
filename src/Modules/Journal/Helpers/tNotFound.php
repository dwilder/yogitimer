<?php
namespace Src\Modules\Journal\Helpers;

/*
 * A view for a Meditation Record Not Found
 */
trait tNotFound
{
    /*
     * Check if the meditation status is NOT FOUND
     */
    protected function notFound()
    {
        if ( isset( $this->data['status'] ) && $this->data['status'] == 'NOT FOUND' ) {
            return true;
        }
        return false;
    }
    
    /*
     * Not Found view
     */
    protected function setNotFoundContent()
    {
        $this->title = 'Meditation Not Found';
        $content = $this->getTitle();
        
        $content .= '<p>The meditation record you have requested could not be found. It has either been permanently deleted or never existed.</p>';
        $content .= '<p><a href="/journal">Back to Journal</a></p>';
        
        $this->content = $content;
    }
}
