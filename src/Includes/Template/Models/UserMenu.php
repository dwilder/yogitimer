<?php
namespace Src\Includes\Template\Models;

use Src\Includes\User\User;

class UserMenu
{
	/*
	 * Store the user menu sections and menu items
	 */
	private $lists = array(
		'Menu' => array(
			'profile' => 'Profile',
			'meditate' => 'Meditate',
			'journal' => array(
			    'primary'   => 'Journal',
                'secondary' => 'add'
			),
            'practices' => array(
                'primary'   => 'Practices',
                'secondary' => 'add'
            )
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
			'guide' => 'Guide',
			'about' => 'About',
			'contact' => 'Contact'
		),
		'Legal' => array(
			'terms' => 'Terms of Service',
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
			
				<a href="#top" class="control menu-close-link"><img src="/assets/img/icons/icon_close.png" class="control" alt="Dismiss" /></a>
				';
				
		$end = '
				<a href="#top" class="control menu-dismiss-link"><img src="/assets/img/icons/icon_close.png" />Dismiss</a>

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
		$html = "<h3><img src=\"/assets/img/icons/icon_" . strtolower( $title ) . ".png\" />$title</h3>";
		$html .= '
			<nav class="user-navigation-submenu">
				<ul>
				';
				
		foreach ( $menu as $guid => $item ) {
			$html .= $this->buildSubMenuItem( $guid, $item );
		}
		
		$html .= "
				</ul>
			</nav>
			";
			
		return $html;
	}
    
    /*
     * Build submenu item
     */
    private function buildSubMenuItem( $guid, $item )
    {
        if ( ! is_array( $item ) ) {
            return '<li><a href="/' . $guid . '">' . $item . '</a></li>';
        }
        return '<li><a href="/' . $guid . '">' . $item['primary'] . '</a><a href="/' . $guid . '/' . $item['secondary'] . '">' . $item['secondary'] . '</a></li>';
    }
}
