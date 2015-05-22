<?php
namespace Src\Modules\Index\Models;

use Src\Modules\Index\Models\AbstractSubsectionModel;

class JoinProfileSubsectionModel extends AbstractSubsectionModel
{
	/*
	 * Set default data
	 */
	public function setData() {
		$this->image = 'indexJoinProfile.jpg';
		$this->content = "Check your Profile to see how you've done over time.";
	}
}