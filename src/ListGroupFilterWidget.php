<?php

namespace ser6io\yii2bs5widgets;

use yii\base\Widget;

class ListGroupFilterWidget extends Widget
{
    public $title = null;
    public $items = [];
    public $total = 1;

    public function run()
    {
        $listItems = [];
        foreach ($this->items as $row) {

            $listItems[] =
            '<a href="#" class="list-group-item list-group-item-action border-bottom-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-nowrap">' . $row['type'] . '</div>
                    <span class="badge bg-primary rounded-pill">' . $row['qty'] . '</span>
                </div>
                <div class="progress mt-1" role="progressbar" style="height: 2px">
                    <div class="progress-bar" style="width: ' . round($row['qty']/$this->total*100) . '%"></div>
                </div>
            </a>';
        }
        $listItems = implode('', $listItems);

        return "<div class='list-group list-group-flush'>
            $this->title\n
            $listItems
        </div>";
    }
}
