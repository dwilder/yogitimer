<?php
namespace Src\Modules\Profile\Views;

use Src\Includes\Reference\Months;

class TimelineView extends AbstractProfileDataView
{
	/*
	 * Define a size for the display area
	 */
	protected $viewSize = 'large';

	protected $title = 'Time Line';
	
	/*
	 * Store the longest meditation time in minutes
	 */
	protected $max;
    
    /*
     * Month name object
     */
    protected $months = null;
	
	protected function buildContent()
	{
		$this->setMax();
		
		$start = '<div id="profile-data-timeline">';
		
		$end = '</div>';
		
		$content = '';
        foreach ( $this->data as $y ) {
            $months = array_keys( $y );
    		foreach ( $months as $m ) {
    			$content .= $this->buildMonth( $y[$m], $this->getMonthName( $m ) );
    		}
        }
		
		$this->content = $start . $content . $end;
	}
	
	protected function buildMonth( $month_data, $month_name )
	{
		$max = $this->max;
		
		$start = '<span id="profile-timeline-' . strtolower( $month_name ) . '" class="profile-timeline-month">';
		$end = '</span>';
		
		$mon = '<span class="profile-timeline-month-initial">' . substr( $month_name, 0, 1 ) . '</span>';
		
		$data = '';
		foreach ( $month_data as $d => $v ) {
			$data .= '<span class="profile-timeline-time" style="height:' . (( $v / $max )*100) . 'px;" data-minutes="' . $v . '"></span>';
		}
		
		return $start . $mon . $data . $end;
	}
	
	/*
	 * Get the max meditation time
	 */
	protected function setMax()
	{
		$highests = array();
        foreach ( $this->data as $y ) {
    		foreach ( $y as $m => $d ) { 
    			$highests[] = max( $d );
    		}
        }
		
		$this->max = max( $highests );
        
        if ( $this->max == 0 ) {
            $this->max = 1;
        }
	}
    
    /*
     * Get the month name
     */
    protected function getMonthName( $number )
    {
        if ( ! $this->months ) {
            $this->months = new Months;
        }
        return $this->months->getMonthName( $number );
    }
}
