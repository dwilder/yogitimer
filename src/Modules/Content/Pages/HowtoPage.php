<?php
namespace Src\Modules\Content\Pages;

/*
 * About page
 */

class HowtoPage
{
	/*
	 * Return the content
	 */
	public function getContent()
	{
		$html = <<<EOT
			<h1>How To</h1>
			<p>This is the how to page that explains how to use the app.</p>
EOT;

		return $html;
	}
}
