<?php
namespace Src\Lib\Template\Models;

use Src\Lib\User\User;

class UserMenu
{
	/*
	 * Store the user menu sections and menu items
	 */
	private $lists = array(
		'Menu' => array(
			'profile' => 'Home',
			'meditate' => 'Meditate',
			'journal' => 'Journal'
		),
		'Admin' => array(
			'users' => 'Users',
			'pages' => 'Pages'
		),
		'Settings' => array(
			'settings' => 'Personal Settings',
			'settings/images' => 'Profile Images',
			'settings/password' => 'Change Password',
			'logout' => 'Logout'
		),
		'Help' => array(
			'howto' => 'How To',
			'about' => 'About',
			'contact' => 'Contact'
		),
		'Legal' => array(
			'terms' => 'Terms of Use',
			'privacy' => 'Privacy Policy'
		)
	);
	
	/*
	 * Return the menu
	 */
	public function getMenu()
	{
		$user = User::getInstance();
        
		if ( $user->isSignedIn() ) {
			return $this->buildMenu();
		}
	}
	
	/*
	 * Build the menu
	 */
	private function buildMenu()
	{
        $user = User::getInstance();
        
		$start = '
		<div id="user-navigation" class="user-navigation"  role="navigation">
			<div class="user-navigation-inner">
			
				<a href="#top" class="control menu-close-link"><img src="/assets/images/icon_close.png" class="control" alt="Dismiss" /></a>
				';
				
		$end = '
				<a href="#top" class="control menu-dismiss-link"><img src="/assets/images/icon_close.png" />Dismiss</a>

			</div>
		</div><!-- .user-navigation -->
			';
		
		$path = '';
		foreach ( $this->lists as $title => $menu ) {
			if ( $title == 'Admin' && ! $user->hasRole('admin') ) {
				continue;
			}
			$path .= $this->buildSubMenu( $title, $menu );
		}
		
		return $start . $path . $end;
	}
	
	
	/*
	 * Build the sub menu
	 */
	private function buildSubMenu( $title, $menu )
	{
		$html = "<h3>$title</h3>";
		$html .= '
			<nav class="user-navigation-submenu">
				<ul>
				';
				
		foreach ( $menu as $guid => $text ) {
			$html .= '<li><a href="/' . $guid . '">' . $text . '</a></li>';
		}
		
		$html .= "
				</ul>
			</nav>
			";
			
		return $html;
	}
}
