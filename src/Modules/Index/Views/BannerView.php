<?php
namespace Src\Modules\Index\Views;

class BannerView
{	
	/*
	 * Build the HTML
	 */
	public function getHTML( $content, $foreground, $midground, $background )
	{
        $fore   = $this->buildList( $foreground, 'banner-foreground' );
        $mid    = $this->buildList( $midground, 'banner-midground' );
        $back   = $this->buildList( $background, 'banner-background' );
        
		$html = <<<EOT

<div class="banner">
        
    <div class="banner-inner">
        
        <div class="banner-tagline">
    		<p>$content</p>
        </div>
    
        <div class="banner-foreground">
            $fore
        </div>
    
        <div class="banner-midground">
            $mid
        </div>
    
        <div class="banner-background">
            $back
        </div>
        
    </div><!-- .banner-inner -->
    
</div><!-- .banner -->
			
EOT;

		return $html;
	}
    
    /*
     * Build lists
     */
    private function buildList( $items, $id_prefix )
    {
        $list = '';
        $i = 1;
        foreach ( $items as $item ) {
            $list .= '<span id="' . $id_prefix . '-' . $i . '">' . $item . '</span>';
            $i++;
        }
        return $list;
    }
}
