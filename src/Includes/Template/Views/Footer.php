<?php
namespace Src\Includes\Template\Views;

use Src\Config\Config;

/*
 * Footer class returns the HTML footer
 */

class Footer
{
	/*
	 * Return the header template
	 */
	public function getTemplate()
	{
        $config = Config::getInstance();
        $url = $config->get('url');
		$year = date('Y');
		
		$html = <<<EOT
<!DOCTYPE html>
		<footer class="site-footer">
		
			{footermenu}
			
			<div class="colophon">
			
				{colophonmenu}
				
				<p class="copyright">&copy $year <a href="http://$url">$url</a></p>
				
			</div>
			
		</footer><!-- .site-footer -->
		
	</main>

	<div id="site-navigation" class="site-navigation"  role="navigation">
	
		{usermenu}
	
	</div><!-- .site-navigation -->
	
	{scripts}

</body>	
</html>
EOT;

		return $html;
	}
}
