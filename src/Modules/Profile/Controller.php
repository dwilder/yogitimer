<?php
namespace Src\Modules\Profile;

use Src\Includes\Module\UIController;
use Src\Includes\User\User;
use Src\Modules\Profile\Models\BannerModel;
use Src\Modules\Profile\Models\MomentumModel;
use Src\Modules\Profile\Models\StabilityModel;
use Src\Modules\Profile\Models\TimelineModel;
use Src\Modules\Profile\Models\MeditationTimeModel;
use Src\Modules\Profile\Views\BannerView;
use Src\Modules\Profile\Views\MomentumView;
use Src\Modules\Profile\Views\StabilityView;
use Src\Modules\Profile\Views\TimelineView;
use Src\Modules\Profile\Views\MeditationTimeView;
	
/*
 * Controller class for the user profile.
 *
 * A user must be signed in to view it.
 */
class Controller extends UIController
{
    /*
     * User must be authenticated
     */
    protected $authenticated = true;
    
	/*
	 * Store models
	 */
	private $BannerModel;
	private $MomentumModel;
	private $StabilityModel;
	private $TimelineModel;
	private $MeditationTimeModel;
	
	/*
	 * Store views
	 */
	private $BannerView;
	private $MomentumView;
	private $StabilityView;
	private $TimelineView;
	private $MeditationTimeView;
	
	/*
	 * Respond to the request
	 */
	public function request()
	{
        $this->testAuthentication();
        
		$this->setModels();
		$this->setViews();
		
		$this->setTemplate();
		$this->template->setGuid( $this->guid );
		$this->template->setContent( $this->getUI() );
		
		return $this->template->request();	
	}
    
	/*
	 * Set models
	 */
	private function setModels()
	{
		$this->BannerModel = new BannerModel;
		$this->BannerModel->run();
        
		$this->MomentumModel = new MomentumModel;
		$this->MomentumModel->run();
        
		$this->StabilityModel = new StabilityModel;
		$this->StabilityModel->run();
        
		$this->TimelineModel = new TimelineModel;
		$this->TimelineModel->run();
        
		$this->MeditationTimeModel = new MeditationTimeModel;
		$this->MeditationTimeModel->run();
	}
	
	/*
	 * Set views
	 */
	private function setViews()
	{
		$this->BannerView = new BannerView;
		$this->BannerView->setData( $this->BannerModel->getData() );

		$this->MomentumView = new MomentumView;
		$this->MomentumView->setData( $this->MomentumModel->getData() );

		$this->StabilityView = new StabilityView;
		$this->StabilityView->setData( $this->StabilityModel->getData() );

		$this->TimelineView = new TimelineView;
		$this->TimelineView->setData( $this->TimelineModel->getData() );

		$this->MeditationTimeView = new MeditationTimeView;
		$this->MeditationTimeView->setData( $this->MeditationTimeModel->getData() );
	}
	
	/*
	 * Build the User Interface
	 */
	private function getUI()
	{
		$html = '';
		$html .= $this->BannerView->getHtml();
		$html .= $this->MomentumView->getHtml();
		$html .= $this->StabilityView->getHtml();
		$html .= $this->TimelineView->getHtml();
		$html .= $this->MeditationTimeView->getHtml();
		
		return $html;
	}
    
    /*
     * Set module name
     */
    protected function setModuleName()
    {
        $this->module_name = 'Profile';
    }
}