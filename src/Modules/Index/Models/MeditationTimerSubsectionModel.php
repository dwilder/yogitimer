<?php
namespace Src\Modules\Index\Models;

use Src\Modules\Index\Models\AbstractSubsectionModel;

class MeditationTimerSubsectionModel extends AbstractSubsectionModel
{
	/*
	 * Set default data
	 */
	public function setData() {
		//$this->image = 'indexMeditationTimer.jpg';
		$this->image = 'index_timer.png';
		$this->content = "The distraction free timer counts the minutes while you meditate.";
	}
}