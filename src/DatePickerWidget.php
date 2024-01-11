<?php

namespace ser6io\yii2bs5widgets;

use yii\helpers\Html;
use yii\base\Widget;

class DatePickerWidget extends Widget
{
    public $model;
    public $caption;
    public $header = null;
    public $color = 'info';
    public $disabled = false;
    public $items;

    public $action = 'set-status';
    public $idField = 'id';

    public function run()
    {
        $datePicker = '<div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-calendar-check"></i> 2024-01-01 - 2024-01-31
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">Last 24 hours</a></li>
                <li><a class="dropdown-item" href="#">Yesterday</a></li>
                <li><a class="dropdown-item" href="#">This week</a></li>
                <li><a class="dropdown-item" href="#">Last 7 days</a></li>
                <li><a class="dropdown-item" href="#">This month</a></li>
                <li><a class="dropdown-item" href="#">Last 30 days</a></li>
                <li><a class="dropdown-item" href="#">Last 90 days</a></li>
                <li><a class="dropdown-item" href="#">This year</a></li>
                <li><a class="dropdown-item" href="#">All time</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Custom range</a></li>
            </ul>
        </div>';

        return $datePicker;
    }
}
