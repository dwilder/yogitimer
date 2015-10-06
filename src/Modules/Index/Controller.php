<?php
namespace Src\Modules\Index;

use Src\Includes\SuperClasses\UIController;
use Src\Modules\Index\Models\BannerModel;
use Src\Modules\Index\Models\MeditateActionModel;
use Src\Modules\Index\Models\RegisterActionModel;
use Src\Modules\Index\Models\SummaryModel;
use Src\Modules\Index\Models\TimerDetailsModel;
use Src\Modules\Index\Models\FeatureDetailsModel;
use Src\Modules\Index\Views\BannerView;
use Src\Modules\Index\Views\IndexActionView;
use Src\Modules\Index\Views\SummaryView;
use Src\Modules\Index\Views\DetailsView;

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
		$this->models['banner']     = new BannerModel;
        $this->models['meditate']   = new MeditateActionModel();
        $this->models['register']   = new RegisterActionModel();
        $this->models['summary']    = new SummaryModel;
        $this->models['timer']      = new TimerDetailsModel;
        $this->models['features']   = new FeatureDetailsModel;
	}
	
	/*
	 * Set views
	 */
	protected function setView()
	{
		$this->views['banner']  = new BannerView;
        $this->views['action']  = new IndexActionView;
        $this->views['summary']  = new SummaryView;
        $this->views['details']  = new DetailsView;
        
	}
	
	/*
	 * Build the HTML
	 */
	protected function respond()
	{
		$content = $this->getBanner();
		
        $content .= $this->getActionView( 'meditate' );
        $content .= $this->getSummary();
        $content .= $this->getDetails();
        $content .= $this->getActionView( 'register' );
        
		$this->template->setContent( $content );
		$this->template->setGuid( 'index' );

        $this->template->setScript( 'utilities.js' );
        $this->template->setScript( 'index.js' );
        
		echo $this->template->request();
	}
	
	/*
	 * Get the banner
	 */
	private function getBanner()
	{
		return $this->views['banner']->getHTML(
			$this->models['banner']->get( 'content' ),
			$this->models['banner']->get( 'foreground' ),
			$this->models['banner']->get( 'midground' ),
			$this->models['banner']->get( 'background' )
		);
	}
    
    /*
     * Get an action view
     */
    private function getActionView( $index )
    {
        return $this->views['action']->getHTML(
            $this->models[$index]->get( 'text' ),
            $this->models[$index]->get( 'subtext' ),
            $this->models[$index]->get( 'url' ),
            $this->models[$index]->get( 'class_suffix' )
        );
    }
    
    /*
     * Get the summary view
     */
    private function getSummary()
    {
        return $this->views['summary']->getHTML(
            $this->models['summary']->get( 'title' ),
            $this->models['summary']->get( 'items' )
        );
    }
    
    /*
     * Get the details view
     */
    private function getDetails()
    {
        return $this->views['details']->getHTML(
            array(
                'title'    => $this->models['timer']->get( 'title' ),
                'text'     => $this->models['timer']->get( 'text' ),
                'images'   => $this->models['timer']->get( 'images' ),
                'alts'     => $this->models['timer']->get( 'alts' )
            ),
            array(
                'title'    => $this->models['features']->get( 'title' ),
                'text'     => $this->models['features']->get( 'text' ),
                'sections' => $this->models['features']->get( 'sections' )
            )
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
