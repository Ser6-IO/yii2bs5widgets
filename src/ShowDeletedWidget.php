<?php

namespace ser6io\yii2bs5widgets;

use Yii;

class ShowDeletedWidget extends \yii\base\Widget
{
    public function run()
    {
        if (Yii::$app->user->can('admin')) {
            return '<br><small>' . \yii\bootstrap5\Html::a('Show Deleted', ['index', 'filter_deleted' => false]) . '</small>';
        } else {
            return '';
        }   
    }
}
?>