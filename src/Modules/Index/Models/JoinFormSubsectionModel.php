<?php
namespace Src\Modules\Index\Models;

use Src\Modules\Index\Models\AbstractSubsectionModel;

class JoinFormSubsectionModel extends AbstractSubsectionModel
{
	/*
	 * Set default data
	 */
	public function setData() {
		$this->image = 'indexJoinForm.jpg';
		$this->content = "Create an account to keep track of your meditations.";
	}
}