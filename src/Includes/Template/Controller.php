<?php
namespace Src\Includes\Template;

use Src\Includes\SuperClasses\UIController;
use Src\Includes\User\User;
use Src\Includes\Template\Views\Menu;
use Src\Includes\Template\Views\Header;
use Src\Includes\Template\Views\Footer;
use Src\Includes\Template\Views\Page;
use Src\Includes\Template\Models\HeaderMenu;
use Src\Includes\Template\Models\UserMenu;
use Src\Includes\Template\Models\FooterMenu;
use Src\Includes\Template\Models\ColophonMenu;

class Controller extends UIController
{
    /*
     * Store the guid
     */
    protected $guid;
    
	/*
	 * Store the page, header and footer
	 */
	private $header;
	private $page;
	private $footer;
	
	/*
	 * Store menus
	 */
	private $menus = array(
		'header' => null,
		'footer' => null,
		'colophon' => null,
		'user' => null
	);
	
	/*
	 * Store the title and content
	 */
	protected $title = null;
	protected $content = null;
	
	/*
	 * Store the body class
	 */
	protected $bodyClass = null;
	
	/*
	 * Store scripts
	 */
	private $scripts = array();
	
	/*
	 * Constructor
	 */
	public function __construct( $title = null )
	{
		$this->setTitle( $title );
		$this->setMenus();
		$this->setHeader();
		$this->setPage();
		$this->setFooter();
	}
    
    /*
     * Set the guid
     */
    public function setGuid( $guid = null )
    {
        if ( ! $guid ) {
            $guid = 'index';
        }
        $this->guid = $guid;
    }
    
    /*
     * Set JS
     */
    public function setScript( $filename )
    {
        $this->scripts[] = $filename;
    }
	
	/*
	 * Set the content
	 */
	public function setContent( $content = null )
	{
		$this->content = $content;
	}
	
	/*
	 * Return the complete page
	 */
	public function request()
	{
		return $this->buildPage();
	}
	
	/*
	 * Set the header
	 */
	private function setHeader()
	{
		$this->header = new Header;
	}
	
	/*
	 * Set the footer
	 */
	private function setFooter()
	{
		$this->footer = new Footer;
	}
	
	/*
	 * Set the page
	 */
	private function setPage()
	{
		$this->page = new Page;
	}
	
	/*
	 * Set the menus
	 */
	private function setMenus()
	{
		$this->menus['header']		= new HeaderMenu;
		$this->menus['user']		= new UserMenu;
		$this->menus['footer']		= new FooterMenu;
		$this->menus['colophon']	= new ColophonMenu;
	}
	
	/*
	 * Set the page title
	 */
	public function setTitle( $title = null )
	{
		if ( $title ) {
			$this->title = $title . ' | Meditate';
		} else {
			$this->title = 'Meditate | A Simple Meditation Timer and Journal';
		}
	}
	
	/*
	 * Build the page
	 */
	private function buildPage()
	{
		$html = $this->header->getTemplate();
		$html .= $this->page->getTemplate();
		$html .= $this->footer->getTemplate();
		
		$html = $this->replaceTags( $html );
		
		return $html;
	}
	
	/*
	 * Replace template tags
	 */
	private function replaceTags( $html )
	{
        $user = User::getInstance();
		// Replace scripts
		$scripts = '';
        if ( $user->isSignedIn() ) {
            $scripts .= '<script src="/assets/js/navigation.js"></script>
                ';
        }
		if ( !empty( $this->scripts ) ) {
			foreach ( $this->scripts as $script ) {
				$scripts .= '<script src="/assets/js/' . $script . '"></script>
                    ';
			}
		}
		$html = str_replace( '{scripts}', $scripts, $html );
		
		// Replace menus
		$this->menus['header']->setGuid( $this->guid );
		foreach ( $this->menus as $k => $v ) {
			$html = str_replace( '{' . $k . 'menu}', $v->getMenu(), $html );
		}
		
		// Replace title
		$html = str_replace( '{title}', $this->title, $html );
		
		// Replace content
		$html = str_replace( '{content}', $this->content, $html );
		
		// Set the body class
		$html = str_replace( '{bodyclass}', ' class="page-' . $this->guid . '"', $html );
		
		return $html;
	}
}
