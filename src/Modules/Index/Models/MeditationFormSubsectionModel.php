<?php
namespace Src\Modules\Index\Models;

use Src\Modules\Index\Models\AbstractSubsectionModel;

class MeditationFormSubsectionModel extends AbstractSubsectionModel
{
	/*
	 * Set default data
	 */
	public function setData() {
		//$this->image = 'indexMeditationForm.jpg';
		$this->image = 'index_form.png';
		$this->content = "Set up your meditation and tap the button to begin.";
	}
}