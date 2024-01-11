<?php

namespace ser6io\yii2bs5widgets;

use yii\helpers\Html;
use yii\base\Widget;

class ScoreCardWidget extends Widget
{
    public $title = null;
    public $value = null;
    public $previousValue = null;
    public $collapse = false;
    public $cardClass = 'card p-2';

    public function run()
    {
        if ($this->previousValue) {
            if ($this->value > $this->previousValue) {
                $trend = '&#x25B4;'; //up
                $color = 'success';
            } elseif ($this->value < $this->previousValue) {
                $trend = '&#x25BE;'; //down
                $color = 'danger';
            } else {
                $trend = "";
                $color = 'info';
            }
            $this->previousValue = abs(round(100 - $this->value / $this->previousValue * 100, 2));
            $trend = "<span class='badge bg-$color'>$trend $this->previousValue%</span>";
        } else {
            $trend = "";
        }

        $scoreCard = "    
            <div class='d-flex justify-content-between'>
                <p class='mb-0'>$this->title<br>$trend</p>
                <p class='display-6 mb-0'>$this->value</p>
            </div>";

        if ($this->collapse) {
            $collapse = "<div class='position-absolute bottom-0 start-50 translate-middle-x'>
                <a id='$this->id-collapse-link' class='text-decoration-none' data-bs-toggle='collapse' href='#$this->id-collapse'>&#x25BE;</a>
            </div>
            <div class='collapse' id='$this->id-collapse'>
                <hr>
                $this->collapse
            </div>
            <script>addCollapseEventListeners('$this->id-collapse', '$this->id-collapse-link');</script>
            ";
        } else {
            $collapse = "";
        }

        return "<div class='$this->cardClass'> $scoreCard\n$collapse</div>";
    }
}
