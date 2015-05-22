<?php
namespace Src\Lib\Template\Views;

/*
 * Header class returns the HTML page section
 */

class Page
{
	/*
	 * Return the header template
	 */
	public function getTemplate()
	{
		$html = <<<EOT
		<div class="site-content">
	
			{content}
	
		</div><!-- .content -->
EOT;

		return $html;
	}
}
