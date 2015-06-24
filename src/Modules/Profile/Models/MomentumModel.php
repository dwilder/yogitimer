<?php
namespace Src\Modules\Profile\Models;

use Src\Modules\Profile\Models\AbstractProfileModel;

/*
 * Momentum represents the meditation requency
 *
 */
class MomentumModel extends AbstractProfileModel
{	
	/*
	 * Set the data values
	 */
	public function run()
	{
        $this->calculateMomentum();
        //$this->data['momentum'] = 100;
	}

    /*
     * Calculate momentum
     *
     * consider total meditation time > 10000hr = 600 000 minutes
     * consider total meditation time > 5000hr = 300 000 minutes
     * consider total meditation time > 1000hr = 60 000 minutes
     *
     * consider ratio of days meditated to not meditated
     * consider past 365 days (ratio out of 25)
     * consider past 60 days (ratio out of 25)
     * consider past 30 days (ratio out of 25)
     * consider past 7 days (ratio out of 15)
     * consider past day (0 or 5)
     *
     * score out of 100 with different levels
     * 
     */
    protected function calculateMomentum()
    {
        $this->data['momentum'] = 0;
        
        // Baseline from total time meditated
        $total_time = $this->meditation_data_model->getTotalTime();
        if ( $total_time > 600000 ) {
            $this->data['momentum'] += 75;
        }
        elseif ( $total_time > 300000 ) {
            $this->data['momentum'] += ( floor( $total_time / 600000 ) * 25 + 50 );
        }
        elseif ( $total_time > 60000 ) {
            $this->data['momentum'] += ( floor( $total_time / 300000 ) * 25 + 25 );
        }
        else {
            $this->data['momentum'] += ( floor( $total_time / 60000 ) * 25 );
        }
        
        // Weighted averages from past number of days
        $past_365 = $this->meditation_data_model->countDays( 365 );
        $past_60 = $this->meditation_data_model->countDays( 60 );
        $past_30 = $this->meditation_data_model->countDays( 30 );
        $past_7 = $this->meditation_data_model->countDays( 7 );
        $past_1 = $this->meditation_data_model->countDays( 1 );
        
        $this->data['momentum'] += floor( 25*$past_365/365 + 25*$past_60/60 + 25*$past_30/30 + 15*$past_7/7 + 5*$past_1 );
        
        if ( $this->data['momentum'] > 100 ) {
            $this->data['momentum'] = 100;
        }
    }
    
}
