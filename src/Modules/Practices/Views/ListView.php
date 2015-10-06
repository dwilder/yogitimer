<?php
namespace Src\Modules\Practices\Views;

use Src\Includes\SuperClasses\View;

class ListView extends View
{
    /*
     * Run
     */
    public function run()
    {
		$start = '<div class="practices-list">';
		$end = '</div>';
		
		$header = $this->getHeaderHtml();
        
        $message = $this->getSessionMessage();
		
		$list = $this->getListHtml();
		
		$this->content = $start . $header . $message . $list . $end;
    }
	
	/*
	 * Build the HTML header
	 */
	protected function getHeaderHtml()
	{
		$ground = '<header class="page-header">';
		$path = '';
		$fruition = '</header>';
		
		$path .= '<h1>Practices</h1>';
		
		$path .= '<div class="page-header-link">';
		$path .= '<a href="/practices/add">Add a Practice</a>';
		$path .= '</div>';
		
		return $ground . $path . $fruition;
	}
    
    /*
     * Build a session message
     */
    protected function getSessionMessage()
    {
        $sm = '';
        if ( ! empty( $this->data['session_message'] ) ) {
            $sm .= '<p class="';
            if ( isset( $this->data['session_message']['success'] ) ) {
                $sm .= 'form-success';
            }
            else {
                $sm .= 'session_message';
            }
            $sm .= '">' . $this->data['session_message']['message'] . '</p>';
        }
        return $sm;
    }
    
    /*
     * Build the list
     */
    protected function getListHtml()
    {
        $html = '';
        
        $practices_obj = $this->data['meditation_practices'];
        $practices = $practices_obj->get();
        
        $records = $this->data['meditation_records'];
        
        foreach ( $practices as $practice ) {
            $html .= $this->getListItemHtml( $practice, $records->getTotalTimeByPractice( $practice['id'] ) );
        }
        
        return $html;
    }
    
    /*
     * Build a single list item
     */
    protected function getListItemHtml( $practice, $current_time )
    {
        
        if ( $practice['goal_time'] != null && $this->hasCompletedPractice( $practice['goal_time'], $current_time ) ) {
            $subclass = 'complete';
        }
        else {
            $subclass = 'ongoing';
        }
        
        $ground = '<div class="card practice-card practice-card-' . $subclass . '">';
        $path = '';
        $fruition = '</div>';
        
        // Title
        $path .= '<p class="practice-title-' . $subclass . '">' . $practice['name'] . '</p>';
        
        //$path .= '<p>Id: ' . $practice['id'] . '; User ID: ' . $practice['user_id'] . '</p>';

        $path .= '<p class="practice-time">Practice Time: ';
        // Different formats if a goal is set
        if ( $practice['goal_time'] != null ) {
            $path .= '<b class="strong">' . ( floor( $current_time/15 ) / 4 ) . '</b>';
            $path .= ' out of <b class="strong">' . $practice['goal_time'] . '</b> ';
            if ( $practice['goal_time'] == 1 ) {
                $path .= 'Hour';
            }
            else {
                $path .= 'Hours';
            }
            $path .= '</p>';
        }
        else {
            $path .= $this->formatTime( $current_time ) . '</p>';
        }
        
        if ( $practice['id'] != 0 ) {
            $path = '<a href="/practices/edit/' . $practice['id'] . '">' . $path . '</a>';
        }
        else {
            $path = '<div class="inner">' . $path . '</div>';
        }
        
        return $ground . $path . $fruition;
    }
    
    /*
     * Format Hours
     */
    protected function formatTime( $minutes )
    {
		$hours = floor( $minutes/15 )/4;
        if ( $hours == 1 ) {
            return $hours . " Hour";
        }
        return $hours . " Hours";
    }
    
    /*
     * Test if a practice has been completed
     */
    protected function hasCompletedPractice( $goal, $current )
    {
        $current = $current/60;
        return ( $current >= $goal );
    }
    
}
