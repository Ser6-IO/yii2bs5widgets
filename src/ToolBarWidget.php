<?php

namespace ser6io\yii2bs5widgets;

use Yii;
use yii\bootstrap5\Html;

class ToolBarWidget extends \yii\base\Widget
{
    public $title;
    public $titleTag = 'h1';
    public $groups;
    public $id;
    public $idParam = 'id';
    public $btnSize = '';
    public $route = '';

    public $isDeleted = false;

    public function run()
    {
        $title = Html::tag($this->titleTag, $this->title);

        $btnSize = ($this->btnSize != '') ? "btn-group-$this->btnSize" : '';

        $route = ($this->route != '') ? "$this->route/" : '';

        $buttons = '';

        foreach ($this->groups as $group) {

            $buttons.="<div class='btn-group $btnSize' role='group'>";

            foreach ($group['buttons'] as $b) {

                if ((is_string($b)) and (isset($group['visible'])) and (Yii::$app->user->can($group['visible']))) {
                    switch ($b) {
                        case 'create':
                            $_caption = '<i class="bi bi-plus-circle"></i>';
                            $_url = ["{$route}create"];
                            if ($this->id != null) $url[$this->idParam] = $this->id;
                            $_options = ['class' => 'btn btn-outline-success', 'data-bs-toggle' => 'tooltip', 'title' => 'New'];
                            break;
                        case 'update':
                            $_caption = '<i class="bi bi-pencil"></i>';
                            $_url = ["{$route}update", $this->idParam => $this->id];
                            $_options = ['class' => 'btn btn-outline-primary', 'data-bs-toggle' => 'tooltip', 'title' => 'Edit'];
                            break;
                        case 'roles':
                            $_caption = '<i class="bi bi-lock"></i>';
                            $_url = ["{$route}roles", $this->idParam => $this->id];
                            $_options = ['class' => 'btn btn-outline-info', 'data-bs-toggle' => 'tooltip', 'title' => 'Roles'];
                            break;
                        case 'send-link':
                            $_caption = '<i class="bi bi-send-plus"></i>';
                            $_url = ["{$route}send-link", $this->idParam => $this->id];
                            $_options = [
                                'class' => 'btn btn-outline-warning', 
                                'data-bs-toggle' => 'tooltip', 
                                'title' => 'Send email',
                                'data' => [
                                    'confirm' => 'Are you sure you want to send a password reset link to this user?',
                                    'method' => 'post',
                                ],
                            ];
                            break;
                        case 'delete':
                            $_caption = '<i class="bi bi-trash"></i>';
                            $_url = ["{$route}delete", $this->idParam => $this->id];
                            $_options = [
                                'class' => 'btn btn-outline-danger',
                                'data-bs-toggle' => 'tooltip', 
                                'title' => 'Delete',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ];
                            break;
                        default:
                            # code...
                            break;
                    }
                    if ($this->isDeleted) {
                        Html::addCssClass($_options, 'disabled');
                    }

                    $buttons.= Html::a($_caption, $_url, $_options);
                } elseif (is_array($b) and (isset($group['visible'])) and (Yii::$app->user->can($group['visible']))) {
                    if (isset($b['html'])) {
                        $buttons.= $b['html'];
                    } else {
                        $buttons.= Html::a($b['label'], $b['url'], $b['options']);
                    }

                }
                
            }

            $buttons.="</div> ";

        }

        if ($this->isDeleted) {
            $deletedBadge = '<span class="badge bg-danger">Deleted</span>';
        } else {
            $deletedBadge = '';
        }
        

        return "<div class='hstack gap-2'>$title $deletedBadge<div class='ms-auto'>$buttons</div></div>";
    }
}

