<?php
namespace Src\Modules\Profile\Views;

class MomentumView extends AbstractProfileDataView
{
	protected $title = 'Momentum';
	
	protected function buildContent()
	{
		$this->content = '
        <div id="profile-data-momentum" class="profile-data-small-display" data-momentum="' . $this->data['momentum'] . '">
            <canvas></canvas>
            <div id="profile-data-momentum-overlay">
                <p class="profile-data-score"><span>' . $this->data['momentum'] . '</span> / 100</p>
                <p class="profile-data-description">Meditate daily to increase your momentum</p>
            </div>
        </div>
        
        <div class="profile-data-inspect">i</div>';
	}
}
