<?php
namespace Src\Modules\Index\Views;

class BannerView
{	
	/*
	 * Build the HTML
	 */
	public function getHTML( $image, $title, $content, $action )
	{
		$html = <<<EOT

<div class="banner">
		
	<div class="banner-image">
		<img src="/assets/images/$image" />
	</div>
	
	<div class="banner-content">
		<h2>$title</h2>
		<p>$content</p>
		<p class="banner-action"><a href="{$action['guid']}">{$action['text']}</a></p>
	</div>
	
</div>	
			
EOT;

		return $html;
	}
}
