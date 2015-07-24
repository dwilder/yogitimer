<?php
namespace Src\Includes\Template\Models;

use Src\Includes\User\User;

class FooterMenu
{
	/*
	 * Store the user menu sections and menu items
	 */
	private $list = array(
		'' => 'Home',
		'about' => 'About',
		'guide' => 'Guide',
		'contact' => 'Contact',
        'login' => 'Login',
        'register' => 'Sign Up'
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
		<nav id="footer-navigation" class="footer-navigation group"  role="navigation">
			<ul>
				';
				
		$end = '
			</ul>
		</nav><!-- .footer-navigation -->
			';
		
		$menu = '';	
		foreach ( $this->list as $guid => $text ) {
			$menu .= '<li class="footer-navigation-' . $guid . '"><a href="/' . $guid . '">' . $text . '</a></li>';
		}
		
		return $start . $menu . $end;
	}
}
