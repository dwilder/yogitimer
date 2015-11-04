<?php
namespace Src\Modules\Profile\Models;

use Src\Modules\Profile\Models\AbstractProfileModel;

class TimelineModel extends AbstractProfileModel
{	
    /*
     * Run
     */
    public function run()
    {
        $this->setDailyMeditationTimes();
    }
    
    /*
     * Set timeline values for the past 365 days
     */
    protected function setDailyMeditationTimes()
    {
        $this->data = $this->meditation_data_model->getTotalTimesByDay();
    }
}
