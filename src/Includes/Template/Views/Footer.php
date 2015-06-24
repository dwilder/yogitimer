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
		<footer class="site-footer">
            <div class="site-footer-inner">
            
			{footermenu}
			
			<div class="colophon">
			
				{colophonmenu}
				
				<p class="copyright">&copy $year <a href="http://$url">$url</a></p>
				
			</div>
			
            </div><!-- .site-footer-inner -->
		</footer><!-- .site-footer -->
		
	</main>

	
	{usermenu}
	
	
	{scripts}

</body>	
</html>
EOT;

		return $html;
	}
}
