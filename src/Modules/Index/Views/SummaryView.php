<?php
namespace Src\Modules\Index\Views;

class SummaryView
{
    public function getHTML( $title, $items )
    {
        $html = '';
        $html .= <<<EOT
            <div class="index-summary group">
                <div>
                    <h2>$title</h2>
EOT;

        foreach ( $items as $item ) {
            $html .= $this->getListItem( $item );
        }
        
        $html .= <<<EOT
                </div>
            </div><!-- .index-summary -->
EOT;
        return $html;
    }
    
    private function getListItem( $item )
    {
        $html = '';
        
        $html .= '<div class="index-summary-item">';
        $html .= '<img src="/assets/img/content/' . $item['image'] . '" alt="' . $item['alt'] . '"/>';
        $html .= '<p>' . $item['text'] . '</p>';
        $html .= '</div>';
        
        return $html;
    }
}
