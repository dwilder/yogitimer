<?php
namespace Src\Modules\Profile\Views;

class MeditationTimeView extends AbstractProfileDataView
{
	/*
	 * Define a size for the display area
	 */
	protected $viewSize = 'large';

	protected $title = 'Meditation Time';
	
	public function buildContent()
	{
		$content = '';
        $content .= '<div class="profile-meditationtime-entries">';
		foreach ( $this->data as $k => $v ) {
			$content .= $this->getEntry( $k, $v );
		}
        $content .= '</div>';
		
		$this->content = $content;
	}
	
	/*
	 * Build the html for a single entry
	 */
	private function getEntry( $k, $v )
	{
		$start = '<div class="profile-meditationtime-entry"><div>';
		$end = '</div></div>';
		
		if ( $k == 'total' ) {
			$header = 'Total Hours';
		} elseif ( $k == date( 'Y' ) ) {
			$header = 'This Year';
		} else {
			$header = $k;
		}
		$header = '<h3 class="profile-meditationtime-header">' . $header . '</h3>';
		
		//$hours = number_format( ( floor($v/15)/4 ), 2 );
		$hours = floor($v/15)/4;
		$data = '<p class="profile-meditationtime-hours" data-hours="' . $hours . '">' . $hours . '</p>';
		
		return $start . $header . $data . $end;
		
	}
	
}
