<?php
namespace Src\Modules\Index\Views;

use Src\Modules\Index\Views\SubsectionView;

class BlockView
{
	/*
	 * Store a subsection
	 */
	private $subsection = null;
	
	/*
	 * Build HTML
	 */
	public function getHTML( $title, $action, $subsections = array() )
	{
		$start = '
			<div class="index-block">
				<h2>' . $title . '</h2>
				';
				
		$end = '
			<p class="index-block-action"><a href="' . $action['guid'] . '">' . $action['text'] . '</a></p>
			</div><!-- .index-block -->
		';
		
		$content = '';
		
		foreach ( $subsections as $data ) {
			$content .= $this->getSubsection( $data );
		}
		
		return $start . $content . $end;
	}
	
	/*
	 * Build subsections
	 */
	private function getSubsection( $data )
	{
		if ( !$this->subsection ) {
			$this->subsection = new SubsectionView;
		}
		
		$output = $this->subsection->getHTML( $data['image'], $data['content'] );
		
		return $output;
	}
}