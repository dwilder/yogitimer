<?php
namespace Src\Modules\Profile\Models;

use Src\Modules\Profile\Models\AbstractProfileModel;

class StabilityModel extends AbstractProfileModel
{	
    /*
     * Run
     */
    public function run()
    {
        $this->calculateStability();
        //$this->data['stability'] = 70;
    }
    
    /*
     * Calculate momentum
     *
     * consider total meditation time > 10000hr = 600 000 minutes
     * consider total meditation time > 5000hr = 300 000 minutes
     * consider total meditation time > 1000hr = 60 000 minutes
     *
     * consider average length of meditations over a number of days
     * consider past 365 days (ratio out of 25)
     * consider past 60 days (ratio out of 25)
     * consider past 30 days (ratio out of 25)
     * consider past 7 days (ratio out of 15)
     * consider past day (0 or 5)
     *
     * score out of 100 with different levels
     * 
     */
    protected function calculateStability()
    {
        // Tuning number (a number of minutes per day to maximize stability)
        $tuner = 120;
        
        $this->data['stability'] = 0;
        
        // Baseline from total time meditated
        $total_time = $this->meditation_data_model->getTotalTime();
        if ( $total_time > 600000 ) {
            $this->data['stability'] += 75;
        }
        elseif ( $total_time > 300000 ) {
            $this->data['stability'] += ( floor( $total_time / 600000 ) * 25 + 50 );
        }
        elseif ( $total_time > 60000 ) {
            $this->data['stability'] += ( floor( $total_time / 300000 ) * 25 + 25 );
        }
        else {
            $this->data['stability'] += ( floor( $total_time / 60000 ) * 25 );
        }
        
        // Weighted averages from past number of days
        $past_365 = $this->meditation_data_model->countTime( 365 );
        $past_60 = $this->meditation_data_model->countTime( 60 );
        $past_30 = $this->meditation_data_model->countTime( 30 );
        $past_7 = $this->meditation_data_model->countTime( 7 );
        $past_1 = $this->meditation_data_model->countTime( 1 );
        
        $this->data['stability'] += floor( ( 25*$past_365/(365) + 25*$past_60/60 + 25*$past_30/30 + 15*$past_7/7 + 5*$past_1 ) / $tuner );
        
        if ( $this->data['stability'] > 100 ) {
            $this->data['stability'] = 100;
        }
    }
}
