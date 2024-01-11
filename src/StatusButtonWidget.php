<?php

namespace ser6io\yii2bs5widgets;

use yii\helpers\Html;
use yii\base\Widget;

class StatusButtonWidget extends Widget
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
        $disabled = $this->disabled ? 'disabled' : '';
        $button = Html::button($this->caption, ['class' => "btn btn-$this->color dropdown-toggle $disabled", 'data-bs-toggle' => 'dropdown', 'aria-expanded' => 'false']);
        $items = $this->header ? ["<li><h6 class='dropdown-header'>$this->header</h6></li>"] : [];
        foreach ($this->items as $key => $value) {
            $items[] = ['label' => $value, 'url' => [$this->action, $this->idField => $this->model->id, 'status' => $key], 'linkOptions' => ['data-method' => 'post']];
        }
        $dropDownMenu = \yii\bootstrap5\Dropdown::widget(['items' => $items]);
        return "<div class='btn-group'>{$button}{$dropDownMenu}</div>";
    }
}
