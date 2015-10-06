<?php
namespace Src\Includes\Template\Models;

use Src\Includes\User\User;

class FooterMenu
{
	/*
	 * Store the user menu sections and menu items
	 */
	private $page_list = array(
		'' => 'Home',
        'meditate' => 'Meditate',
		'guide' => 'Guide',
		'about' => 'About',
		'contact' => 'Contact'
	);
    private $user_list = array(
        'login' => 'Log In',
        'signup' => 'Sign Up'
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
		<nav id="footer-navigation" class="footer-navigation group">
				';
				
		$end = '
		</nav><!-- .footer-navigation -->
			';
		
		$menu = $this->buildList( $this->page_list, 'footer-navigation-pages');
		$menu .= $this->buildList( $this->user_list, 'footer-navigation-user');
		
		return $start . $menu . $end;
	}
    
    /*
     * Build a list
     */
    private function buildList( $list, $class )
    {
        $html = '<ul class="' . $class . '">';
        foreach ( $list as $guid => $text ) {
			$html .= '<li class="footer-navigation-' . $guid . '"><a href="/' . $guid . '">' . $text . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }
}
