<?php

namespace ser6io\yii2bs5widgets;

class ListView extends \yii\widgets\ListView
{
    public $layout = "{items}<div class='d-sm-flex justify-content-between align-items-center'>{summary}{pager}</div>";

    public $pager = [
        'options' => ['class' => 'pagination my-0'],
        'linkContainerOptions' => ['class' => 'page-item'],
        'linkOptions' => ['class' => 'page-link'],
        'disabledListItemSubTagOptions' => ['class' => 'page-link'],
        'firstPageLabel' => '&lt;',
        'lastPageLabel'  => '&gt;',
        'maxButtonCount' => 5,
    ];
}