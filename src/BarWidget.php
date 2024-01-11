<?php

namespace ser6io\yii2bs5widgets;

use yii\base\Widget;

class BarWidget extends Widget
{
    public $title = null;
    public $items = [];
    public $total = 1;
    public $types = [];
    public $colors = [];
    
    public function run()
    {
        $listItems = [];
        $barItems = [];
        foreach ($this->items as $row) {
            $listItems[] =
            '<a href="#" class="list-group-item list-group-item-action">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-nowrap">' . $this->types[$row['type']] . '</div>
                    <span class="badge bg-' . $this->colors[$row['type']] . ' rounded-pill">' . $row['qty'] . '</span>
                </div>
            </a>';
            $percent = round($row['qty']/$this->total*100);
            $barItems[] = 
            "<div class='progress' style='width: $percent%'>
                <div class='progress-bar bg-" . $this->colors[$row['type']] . "'></div>
            </div>";
        }

        return "<div>
            $this->title
            <div class='list-group list-group-horizontal-md my-2'>"
            . implode('', $listItems) .
            "</div>
            <div class='progress-stacked mt-2'>"
            . implode('', $barItems) .
            "</div>
            </div>";
    }
}