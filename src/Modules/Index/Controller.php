<?php
namespace Src\Modules\Index;

use Src\Includes\SuperClasses\UIController;
use Src\Modules\Index\Models\BannerModel as BannerModel;
use Src\Modules\Index\Models\MeditationBlockModel as MeditationBlockModel;
use Src\Modules\Index\Models\JoinBlockModel as JoinBlockModel;
use Src\Modules\Index\Views\BannerView as BannerView;
use Src\Modules\Index\Views\BlockView as BlockView;

/*
 * Controller class for index.
 */

class Controller extends UIController
{
	/*
	 * Store models and views
	 */
	private $models = array();
	private $views = array();
    
    /*
     * Set module name
     */
    protected function setModuleName() {}
	
	/*
	 * Set models
	 */
	protected function setModel()
	{
		$this->models['banner'] = new BannerModel;
		$this->models['meditation'] = new MeditationBlockModel;
		$this->models['join'] = new JoinBlockModel;
	}
	
	/*
	 * Set views
	 */
	protected function setView()
	{
		$this->views['banner'] = new BannerView;
		$this->views['meditation'] = new BlockView;
		$this->views['join'] = new BlockView;
	}
	
	/*
	 * Build the HTML
	 */
	protected function respond()
	{
		$content = $this->getBanner();
		
		$content .= $this->getBlock( 'meditation' );
		
		$content .= $this->getBlock( 'join' );

		$this->template->setContent( $content );
		$this->template->setGuid( 'index' );
		
		echo $this->template->request();
	}
	
	/*
	 * Get the banner
	 */
	private function getBanner()
	{
		return $this->views['banner']->getHTML(
			$this->models['banner']->get( 'image' ),
			$this->models['banner']->get( 'title' ),
			$this->models['banner']->get( 'content' ),
			$this->models['banner']->get( 'action' )
		);
	}
	
	/*
	 * Get a block
	 */
	private function getBlock( $block )
	{
		$output = $this->views[$block]->getHTML(
			$this->models[$block]->get( 'title' ),
			$this->models[$block]->get( 'action' ),
			$this->models[$block]->getSubsectionData()
		);
		
		return $output;
	}
}
