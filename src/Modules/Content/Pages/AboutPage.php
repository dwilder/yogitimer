<?php
namespace Src\Modules\Content\Pages;

/*
 * About page
 */

class AboutPage
{
	/*
	 * Return the content
	 */
	public function getContent()
	{
		$html = <<<EOT
			<h1>About</h1>
			<p>This is about the application.</p>
EOT;

		return $html;
	}
}
