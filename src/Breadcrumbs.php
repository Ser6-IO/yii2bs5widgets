<?php

namespace ser6io\yii2bs5widgets;

use Yii;

class Breadcrumbs extends \yii\bootstrap5\Breadcrumbs
{

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (!empty(Yii::$app->view->params['breadcrumbs'])) {

            $this->links = Yii::$app->view->params['breadcrumbs'];

            $this->homeLink = [
                'label' => '<i class="bi bi-house"></i>',
                'url' => Yii::$app->homeUrl,
                'encode' => false,
            ];

        }
        
    }

}

