<?php
namespace Src\Modules\Profile\Views;

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
	
	protected function buildContent()
	{
		$this->setMax();
		
		$start = '<div id="profile-data-timeline">';
		
		$end = '</div>';
		
		$content = '';
		foreach( $this->data as $m => $d ) {
			$content .= $this->buildMonth( $m, $d );
		}
		
		$this->content = $start . $content . $end;
	}
	
	protected function buildMonth( $month, $days )
	{
		$max = $this->max;
		
		$start = '<span id="profile-timeline-' . strtolower( $month ) . '" class="profile-timeline-month">';
		$end = '</span>';
		
		$mon = '<span class="profile-timeline-month-initial">' . substr( $month, 0, 1 ) . '</span>';
		
		$data = '';
		foreach ( $days as $d => $v ) {
			$data .= '<span style="height:' . (( $v / $max )*100) . 'px;width:1px;background:#888;display:inline-block" data-minutes="' . $v . '"></span>';
		}
		
		return $start . $mon . $data . $end;
	}
	
	/*
	 * Get the max meditation time
	 */
	protected function setMax()
	{
		$highests = array();
		foreach ( $this->data as $m => $d ) {
			$highests[] = max( $d );
		}
		
		$this->max = max( $highests );
	}
}
