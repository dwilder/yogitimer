<?php
namespace Src\Modules\Profile;

use Src\Includes\SuperClasses\UIController;
use Src\Includes\User\User;
use Src\Modules\Profile\Models\MeditationDataModel;
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
    private $meditation_data_model;
	
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
	protected function setModel()
	{
        $this->meditation_data_model = new MeditationDataModel();
        
		$this->BannerModel = new BannerModel;
		$this->BannerModel->run();
        
		$this->MomentumModel = new MomentumModel;
		$this->MomentumModel->setMeditationDataModel( $this->meditation_data_model );
		$this->MomentumModel->run();
        
		$this->StabilityModel = new StabilityModel;
		$this->StabilityModel->setMeditationDataModel( $this->meditation_data_model );
		$this->StabilityModel->run();
        
		$this->TimelineModel = new TimelineModel;
		$this->TimelineModel->setMeditationDataModel( $this->meditation_data_model );
		$this->TimelineModel->run();
        
		$this->MeditationTimeModel = new MeditationTimeModel;
		$this->MeditationTimeModel->setMeditationDataModel( $this->meditation_data_model );
		$this->MeditationTimeModel->run();
	}
	
	/*
	 * Set views
	 */
	protected function setView()
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
	protected function getUI()
	{
		$html = '';
		$html .= $this->BannerView->run();
		$html .= $this->MomentumView->getHtml();
		$html .= $this->StabilityView->getHtml();
		$html .= $this->TimelineView->getHtml();
		$html .= $this->MeditationTimeView->getHtml();
		
		return $html;
	}
    
	/*
	 * Return UI
	 */
	protected function respond()
	{
        if ( isset( $this->request['guid'] ) ) {
    		$this->template->setGuid( $this->request['guid'] );
        }
        $this->template->setScript('utilities.js');
        $this->template->setScript('momentum.js');
        $this->template->setScript('stability.js');
		$this->template->setContent( $this->getUI() );
		echo $this->template->request();
	}
}