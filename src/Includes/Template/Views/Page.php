<?php
namespace Src\Includes\Template\Views;

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
            <div class="site-content-inner">
	
    			{content}
	
            </div><!-- .site-content-inner -->
		</div><!-- .content -->
EOT;

		return $html;
	}
}
