<?php

namespace ser6io\yii2bs5widgets\searchmodalwidget;

use ser6io\yii2bs5widgets\searchmodalwidget\assets\SearchModalWidgetAsset;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

class SearchModalWidget extends Widget
{
    public $model;
    public $attribute;
    public $label;
    public $searchUrl;
    public $inputId;
    public $createUrl;

    public function init()
    {
        parent::init();

        $address_types = \ser6io\yii2contacts\models\Address::ADDRESS_TYPE;
        $this->view->registerJsVar("address_types", Json::encode($address_types));

        if (!$this->label) {
            $this->label = $this->model->getAttributeLabel($this->attribute);
        }

        if (!$this->inputId) {
            $this->inputId = Html::getInputId($this->model, $this->attribute);
        }

        $_model = $this->model->address->attributes ?? null;
        if ($_model) {
            $_model['organization']['nickname'] = $this->model->address->organization->nickname ?? null;
        }
        
        $this->view->registerJsVar("{$this->id}_search_widget_data", Json::encode([
            'hiddenInputId' => $this->inputId,
            'searchUrl' => $this->searchUrl,
            'model' => $_model,
            'widgetId' => $this->id,
            'label' => $this->label,
        ]));
        
        SearchModalWidgetAsset::register($this->view);

        $this->view->registerJs(
            "initSearchWidget({$this->id}_search_widget_data);",
            \yii\web\View::POS_READY,
            "$this->id-init"
        );

    }

    public function run()
    {
        return $this->render('search-card', [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'label' => $this->label,
            'searchUrl' => $this->searchUrl,
            'inputId' => $this->inputId,
            'createUrl' => $this->createUrl,
        ]);   
    }
}