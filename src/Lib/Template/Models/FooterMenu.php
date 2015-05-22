<?php
namespace Src\Lib\Template\Models;

use Src\Lib\User\User;

class FooterMenu
{
	/*
	 * Store the user menu sections and menu items
	 */
	private $list = array(
		'/' => 'Home',
		'about' => 'About',
		'howto' => 'How To',
		'contact' => 'Contact'
	);
	
	/*
	 * Return the menu
	 */
	public function getMenu()
	{
		$user = User::getInstance();
        
		if ( ! $user->isSignedIn() ) {
			return $this->buildMenu();
		}
	}
	
	/*
	 * Build the menu
	 */
	private function buildMenu()
	{
		$start = '
		<nav id="footer-navigation" class="footer-navigation"  role="navigation">
			<ul>
				';
				
		$end = '
			</ul>
		</nav><!-- .footer-navigation -->
			';
		
		$menu = '';	
		foreach ( $this->list as $guid => $text ) {
			$menu .= '<li><a href="' . $guid . '">' . $text . '</a></li>';
		}
		
		return $start . $menu . $end;
	}
}
