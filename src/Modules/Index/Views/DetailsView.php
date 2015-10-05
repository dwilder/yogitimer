<?php
namespace Src\Modules\Index\Views;

class DetailsView
{
    public function getHTML( $timer, $features )
    {
        $html = <<<EOT
        <div class="index-details group">
            <div class="index-details-timer">
            
                <h2>{$timer['title']}</h2>

                <div class="index-details-timer-closeup group">
                    <img src="/assets/img/content/{$timer['images'][0]}" alt="{$timer['alts'][0]}" />
                </div>
                
                <div class="index-details-timer-info">
                
                    <p>{$timer['text'][0]}</p>
                    <p>{$timer['text'][1]}</p>
                    
                    <div class="index-details-timer-images">
                        <div class="index-details-timer-tablet">
                            <img src="/assets/img/content/{$timer['images'][2]}" alt="{$timer['alts'][2]}" />
                        </div>
                        <div class="index-details-timer-laptop">
                            <img src="/assets/img/content/{$timer['images'][3]}" alt="{$timer['alts'][3]}" />
                        </div>
                        <div class="index-details-timer-phone">
                            <img src="/assets/img/content/{$timer['images'][1]}" alt="{$timer['alts'][1]}" />
                        </div>
                    </div>
                    
                </div>
                
            </div><!-- .index-details-timer -->
            
            <div class="index-details-features">
            
                <h2>{$features['title']}</h2>
                <p>{$features['text']}</p>
                
EOT;
            $html .= $this->buildFeatures( $features['sections'] );
            $html .= <<<EOT
            
            </div><!-- .index-details-features -->
            
        </div><!-- .index-details -->
EOT;

        return $html;
    }
    
    private function buildFeatures( $features )
    {
        $html = '';
        foreach ( $features as $f ) {
            $html .= $this->buildFeature( $f );
        }
        return $html;
    }
    
    private function buildFeature( $f )
    {
        $html = <<<EOT
            <div class="index-details-features-feature">
                <h3>{$f['title']}</h3>
                <div>
                    <img src="/assets/img/content/{$f['image']}" alt="{$f['alt']}"/>
                </div>
                <p>{$f['text']}</p>
            </div>    
EOT;
        return $html;
    }
}
