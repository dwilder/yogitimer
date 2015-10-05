<?php
namespace Src\Modules\Index\Views;

class IndexActionView
{
    protected $text;
    protected $subtext;
    protected $url;
    protected $class;
    
    public function getHTML( $text, $subtext, $url, $class_suffix )
    {
        $html = <<<EOT
        <div class="index-action index-action-$class_suffix">
        
            <a href="/$url" class="index-action-button">
                <h2>$text</h2>
                <p>$subtext</p>
            </a>
            
        </div><!-- .index-action -->
EOT;

        return $html;
    }
}
