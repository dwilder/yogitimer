<?php
namespace Src\Modules\Index\Models;

use Src\Modules\Index\Models\AbstractBlockModel;
use Src\Modules\Index\Models\MeditationFormSubsectionModel;
use Src\Modules\Index\Models\MeditationTimerSubsectionModel;

class MeditationBlockModel extends AbstractBlockModel
{
	/*
	 * Set default data
	 */
	public function setData() {
		$this->title = "Get Focused";
		$this->action['text'] = "Start Meditating";
		$this->action['guid'] = "meditate";
	}
	
	/*
	 * Set subsections
	 */
	public function setSubsections() {
		$this->subsections[] = new MeditationFormSubsectionModel;
		$this->subsections[] = new MeditationTimerSubsectionModel;
	}
}
