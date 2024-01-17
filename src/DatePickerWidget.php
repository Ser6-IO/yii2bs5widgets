<?php

namespace ser6io\yii2bs5widgets;

use yii\helpers\Html;
use yii\base\Widget;

class DatePickerWidget extends Widget
{
    public $icon = 'calendar-check';
    //public $caption = 'YYYY-MM-DD - YYYY-MM-DD';
    public $color = 'info';
    public $range;

    public $model;
    public $range_attribute = 'range';
    public $from_attribute = 'from';
    public $to_attribute = 'to';
    public $formId;

    public function run()
    {
        $rangeInputId = Html::getInputId($this->model, $this->range_attribute);
        $fromInputId = Html::getInputId($this->model, $this->from_attribute);
        $toInputId = Html::getInputId($this->model, $this->to_attribute);

        $rangeHiddenInput = Html::activeHiddenInput($this->model, $this->range_attribute);
        $fromHiddenInput = Html::activeHiddenInput($this->model, $this->from_attribute);
        $toHiddenInput = Html::activeHiddenInput($this->model, $this->to_attribute);


        $rangeArray = [];
        foreach ($this->range as $key => $range) {
            $rangeArray[] = Html::tag('li', Html::a($range, '#', ['class' => 'dropdown-item', 'onclick' => "document.getElementById('$rangeInputId').value = $key; document.getElementById('$this->formId').submit();"]));
        }
        $rangeArray[] = Html::tag('li', Html::tag('hr', '', ['class' => 'dropdown-divider']));
        $rangeArray[] = Html::tag('li', Html::a('Custom range', '#', ['class' => 'dropdown-item']));

        $icon = "<i class='bi bi-$this->icon'></i>";
        $button = Html::tag('button', "$icon " . $this->range[$this->model->{$this->range_attribute}], ['class' => "btn btn-outline-$this->color dropdown-toggle", 'type' => 'button', 'data-bs-toggle' => 'dropdown']);
        $ul = Html::tag('ul', implode('', $rangeArray), ['class' => 'dropdown-menu']);

        return Html::tag('div',"$button\n$ul", ['class' => 'dropdown']) . $rangeHiddenInput; // . $fromHiddenInput . $toHiddenInput;
    }
}
