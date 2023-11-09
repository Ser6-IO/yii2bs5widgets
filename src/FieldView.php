<?php

namespace ser6io\yii2bs5widgets;

use Yii;
use yii\base\Widget;
use yii\bootstrap5\Html;

class FieldView extends Widget
{
    public $model;
    public $attribute;
    public $tag = 'div';
    public $list = false;
    public $options = [];
    public $format;
    public $label;

    public function run()
    {
        if ($this->label === null) {
            $this->label = $this->model->getAttributeLabel($this->attribute);
        }

        if ($this->list) {
            $rawValue = $this->list[$this->model->{$this->attribute}];
        } else {
            $rawValue = $this->model->{$this->attribute};
        }

        if ($this->format and ($rawValue != '')) {
            $rawValue = Yii::$app->formatter->format($rawValue, $this->format);
        }

        if ($rawValue == '')
            $rawValue = '&nbsp;';

        $value = Html::tag($this->tag, $rawValue, $this->options);

        return  "<div class='card p-2'><small class='text-muted'>$this->label</small>$value</div>";
    }
}
