<?php
namespace Src\Lib\Template;

use Src\Lib\Module\UIController;
use Src\Lib\Template\Views\Menu;
use Src\Lib\Template\Views\Header;
use Src\Lib\Template\Views\Footer;
use Src\Lib\Template\Views\Page;
use Src\Lib\Template\Models\HeaderMenu;
use Src\Lib\Template\Models\UserMenu;
use Src\Lib\Template\Models\FooterMenu;
use Src\Lib\Template\Models\ColophonMenu;

class Controller extends UIController
{
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
     * Set the module name
     */
    protected function setModuleName() {}
	
	/*
	 * Set the content
	 */
	public function setContent( $content )
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
		// Replace scripts
		$scripts = '';
		if ( !empty( $this->scripts ) ) {
			foreach ( $this->scripts as $script ) {
				$scripts .= '<script src="/assets/js/' . $script . '"></script>' . "/n";
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
