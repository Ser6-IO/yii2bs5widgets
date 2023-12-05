<?php

namespace ser6io\yii2bs5widgets;

use Yii;
use yii\base\Widget;
use yii\bootstrap5\Html;
use yii\helpers\Json;
use ser6io\yii2bs5widgets\assets\AddressCardAsset;

class AddressCardWidget extends Widget
{
    public $model;
    public $attribute;
    public $label;

    public function init()
    {
        parent::init();
        if ($this->label === null) {
            $this->label = $this->model->getAttributeLabel($this->attribute);
        }

        AddressCardAsset::register($this->view);

        $_model = $this->model->attributes ?? null;
        if ($_model) {
            $_model['contact']['name'] = $this->model->contact->name ?? null;
        }

        $address_types = \ser6io\yii2contacts\models\Address::ADDRESS_TYPE;
        $this->view->registerJsVar("address_types", Json::encode($address_types));

        $JsVarName = "$this->attribute" . "_data";
        $this->view->registerJsVar($JsVarName, Json::encode([
            'model' => $_model,
            'label' => $this->label,
        ]));
        $this->view->registerJs("renderContactItemView('$this->attribute', $JsVarName)");


    }

    public function run()
    {
        return  "<div class='card p-2'>
                    <p id='$this->attribute' class='card-text placeholder-glow'>
                        <span class='placeholder col-7'></span>
                        <span class='placeholder col-4'></span>
                        <span class='placeholder col-6'></span>
                    </p>
                </div>";
    }
}
