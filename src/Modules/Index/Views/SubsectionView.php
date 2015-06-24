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
                <div class="index-block-subsection-image-inner">
    				<img src="/assets/img/content/$image" />
                </div>
			</div>
		
			<p>$content</p>
		
		</div>
EOT;
		return $output;
	}
}