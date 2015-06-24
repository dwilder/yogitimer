<?php
namespace Src\Modules\Profile\Models;

use Src\Modules\Profile\Models\AbstractProfileModel;

class MeditationTimeModel extends AbstractProfileModel
{	
    /*
     * Run
     */
    public function run()
    {
        $this->calculateHours();
    }
	
    /*
     * Calculate meditation times
     */
    private function calculateHours()
    {
        $this->data['total'] = $this->meditation_data_model->getTotalTime();
        $this->data = $this->data + $this->meditation_data_model->getTotalTimesByYear();
    }
}
