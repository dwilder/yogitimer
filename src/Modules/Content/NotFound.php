<?php
namespace Src\Modules\Content;

/*
 * 404 Not Found page
 */

class NotFound
{
	/*
	 * Return the content
	 */
	public function getContent()
	{
		$html = <<<EOT
			<div class="notfound">
				<h1>404 Error</h1>
				<p>The page you are looking for could not be found.</p>
			</div>
EOT;

		return $html;
	}
}
