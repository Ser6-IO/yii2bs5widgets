<?php

namespace ser6io\yii2bs5widgets\helpers;

use yii\base\View;
use yii\base\Behavior;
use Yii;

/**
 * Automatically sets the title and breadcrumbs for the view
 *
 */

class Viewparamsbehavior extends Behavior
{
    public function events()
    {
        return [
            View::EVENT_BEFORE_RENDER => 'beforeRender',
        ];
    }

    public function beforeRender($event)
    {
        $view = $event->sender;

        //If Page Title NOT already set...
        if (!$view->title) {

            $moduleName = ucwords(Yii::$app->controller->module->id);
            $controllerName = ucwords(Yii::$app->controller->id);
            $actionName = ucwords(Yii::$app->controller->action->id);

            if (((Yii::$app->controller->id == Yii::$app->defaultRoute) and (Yii::$app->controller->action->id == Yii::$app->controller->defaultAction))) {
                //We are in the Main App and default controller/action: No BreadCrumbs.
                $view->title = $moduleName;
                $view->params['breadcrumbs'] = [];

            } else {
            
                $view->title = "$moduleName - $controllerName";

                //Add Module name to Breadcrumbs if we are in the Main App
                if (Yii::$app->id != Yii::$app->controller->module->id) {
                    $view->params['breadcrumbs'][] = [
                        'label' => $moduleName, 
                        'url' => '/' . Yii::$app->controller->module->id,
                        'class' => ['text-decoration-none', 'fw-bold']
                    ];
                }
            
                if (Yii::$app->controller->action->id == Yii::$app->controller->defaultAction) {
                    
                    $view->params['breadcrumbs'][] = $controllerName;

                } elseif (Yii::$app->controller->id == Yii::$app->defaultRoute) {

                    $view->params['breadcrumbs'][] = $actionName;

                } else {
                    
                    $view->params['breadcrumbs'][] = [
                            'label' => $controllerName, 
                            'url' => '/' . Yii::$app->controller->module->id . '/' . Yii::$app->controller->id,
                            'class' => ['text-decoration-none', 'fw-bold']
                    ];
                                    
                    $view->params['breadcrumbs'][] = $actionName;
                }
            }
        }
    }
}