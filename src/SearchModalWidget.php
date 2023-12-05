<?php

namespace ser6io\yii2bs5widgets;

use ser6io\yii2bs5widgets\assets\SearchModalAsset;
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
    public $inputName;
    public $createUrl;
    public $relation;

    public $form;

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

        if (!$this->inputName) {
            $this->inputName = Html::getInputName($this->model, $this->attribute);
        }

        if (!$this->relation) {
            //split attribute name by '_'
            $this->relation = explode('_', $this->attribute)[0];
        }

        $_model = $this->model->{$this->relation}->attributes ?? null;
        if ($_model) {
            $_model['contact']['name'] = $this->model->{$this->relation}->contact->name ?? null;
        }
        
        $this->view->registerJsVar("{$this->id}_search_widget_data", Json::encode([
            'hiddenInputId' => $this->inputId,
            'hiddenInputName' => $this->inputName,
            'searchUrl' => $this->searchUrl,
            'model' => $_model,
            'widgetId' => $this->id,
            'formId' => $this->form->id,
            'label' => $this->label,
        ]));
        
        SearchModalAsset::register($this->view);

        $this->view->registerJs(
            "initSearchWidget({$this->id}_search_widget_data);",
            \yii\web\View::POS_READY,
            "$this->id-init"
        );

    }

    public function run()
    {
        return $this->render('search-modal', [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'label' => $this->label,
            'searchUrl' => $this->searchUrl,
            'inputId' => $this->inputId,
            'createUrl' => $this->createUrl,
            'form' => $this->form,
        ]);   
    }
}