<?php
namespace Src\Modules\Profile\Views;

class MomentumView extends AbstractProfileDataView
{
	protected $title = 'Momentum';
	
	protected function buildContent()
	{
		$this->content = '<div id="profile-data-momentum>" data-momentum="' . $this->data['momentum'] . '">' . $this->data['momentum'] . '</div>';
	}
}
