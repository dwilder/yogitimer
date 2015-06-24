<?php
namespace Src\Modules\Index\Models;

use Src\Modules\Index\Models\AbstractSubsectionModel;

class JoinProfileSubsectionModel extends AbstractSubsectionModel
{
	/*
	 * Set default data
	 */
	public function setData() {
		//$this->image = 'indexJoinProfile.jpg';
		$this->image = 'index_journal.png';
		$this->content = "Check your journal to see how you've done over time.";
	}
}