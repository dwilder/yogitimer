<?php
namespace Src\Modules\Index\Views;

class SubsectionView
{
	/*
	 * Return the HTML
	 */
	public function getHTML( $image, $content )
	{
		$output = <<<EOT
		<div class="index-block-subsection">
		
			<div class="index-block-subsection-image">
				<img src="/assets/images/$image" />
			</div>
		
			<p>$content</p>
		
		</div>
EOT;
		return $output;
	}
}