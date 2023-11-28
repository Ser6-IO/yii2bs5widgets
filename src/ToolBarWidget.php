<?php

namespace ser6io\yii2bs5widgets;

use Yii;
use yii\bootstrap5\Html;

/**
 * ToolBarWidget widget renders a toolbar
 *
 * To use the ToolBarWidget widget, you may insert the following code in a view:
 *
 * ```php
 * echo ToolBarWidget::widget([
 *     'title' => 'Addresses',
 *     'titleTag' => 'h4',
 *     'groups' => [
 *         ['buttons' => ['create'], 'visible' => Yii::$app->user->can('contacts')],
 *         ['buttons' => ['show-deleted'], 'visible' => Yii::$app->user->can('admin')],  
 *     ],
 *     'btnSize' => 'sm',
 *     'route' => 'address',
 *     'id' => $model->id,
 *     'idParam' => $idParam,
 * ]);
 * ```
 *
 * Each group is an array with the following structure:
 * - `visible`: _boolean_, optional, whether the group is visible. Defaults to `true`.
 * - `buttons`: array of buttons to be displayed in the group. Each element can be:
 * -- string: 'create', 'update', 'delete', 'soft-delete', 'restore', 'roles', 'send-link', 'show-deleted'
 * -- array: ['label' => '...', 'url' => '...', 'options' => '...']
 * -- array: ['html' => '...']
 */

class ToolBarWidget extends \yii\base\Widget
{
    public $title;
    public $titleTag = 'h1';
    public $btnSize = '';
    public $isDeleted = false;
    public $groups;
    
    public $id;
    //public $idParam = 'id';

    public function run()
    {
        $title = Html::tag($this->titleTag, $this->title);

        $btnSize = ($this->btnSize != '') ? "btn-group-$this->btnSize" : '';

        $buttons = '';

        $deletedBadge = '';

        foreach ($this->groups as $group) {

            if ((isset($group['visible'])) and ($group['visible'] === False))
                continue;
             
            $buttons.="<div class='btn-group $btnSize' role='group'>";

            foreach ($group['buttons'] as $b) {

                if ((is_string($b))) {
                    switch ($b) {
                        case 'create':
                            
                            $_url = $group['config']['create']['url'] ?? ['create'];
                            $_caption = '<i class="bi bi-plus-circle"></i>';
                            $_options = ['class' => 'btn btn-outline-success', 'data-bs-toggle' => 'tooltip', 'title' => 'New'];
                            break;
                        
                        case 'show-deleted':

                            $_url = $group['config']['show-deleted']['url'] ?? ['index'];
                            $_caption = '<i class="bi bi-recycle"></i>';
                            $filter_deleted = Yii::$app->request->get('filter_deleted');
                            if ($filter_deleted) {
                                $_options = ['class' => 'btn btn-outline-warning', 'data-bs-toggle' => 'tooltip', 'title' => 'Hide Deleted'];
                                $deletedBadge = '<span class="badge bg-danger">Showing Deleted items</span>';
                            } else {
                                $_url['filter_deleted'] = 1;
                                $_options = ['class' => 'btn btn-outline-danger', 'data-bs-toggle' => 'tooltip', 'title' => 'Show Deleted'];
                            }
                            break;


                        case 'update':
                            
                            $_url = $group['config']['update']['url'] ?? ['update', 'id' => $this->id];
                            $_caption = '<i class="bi bi-pencil"></i>';
                            $_options = ['class' => 'btn btn-outline-primary', 'data-bs-toggle' => 'tooltip', 'title' => 'Edit'];
                            if ($this->isDeleted)
                                Html::addCssClass($_options, 'disabled');
                            break;

                        case 'roles':
                            
                            $_url = $group['config']['roles']['url'] ?? ['roles', 'id' => $this->id];
                            $_caption = '<i class="bi bi-lock"></i>';
                            $_options = ['class' => 'btn btn-outline-info', 'data-bs-toggle' => 'tooltip', 'title' => 'Roles'];
                            if ($this->isDeleted)
                                Html::addCssClass($_options, 'disabled');

                            break;
                        case 'send-link':
                            
                            $_url = $group['config']['send-link']['url'] ?? ['send-link', 'id' => $this->id];
                            $_caption = '<i class="bi bi-send-plus"></i>';
                            $_options = [
                                'class' => 'btn btn-outline-warning', 
                                'data-bs-toggle' => 'tooltip', 
                                'title' => 'Send email',
                                'data' => [
                                    'confirm' => 'Are you sure you want to send a password reset link to this user?',
                                    'method' => 'post',
                                ],
                            ];
                            if ($this->isDeleted)
                                Html::addCssClass($_options, 'disabled');
                            break;

                        case 'soft-delete':
                            
                            $_route = $group['config']['soft-delete']['route'] ?? '';
                            if ($_route != '')
                                $_route = "$_route/"; 

                            if ($this->isDeleted) {
                                $_title = 'Delete Permanently';
                                $_u = "{$_route}delete";
                                $_class = 'btn btn-danger';
                                $_confirm = 'Are you sure you want to PERMANENTLY delete this item?<br>This action cannot be undone.';
                            } else {
                                $_title = 'Delete';
                                $_u = "{$_route}soft-delete";
                                $_class = 'btn btn-outline-danger';
                                $_confirm = 'Are you sure you want to delete this item?';
                            }

                            $_caption = '<i class="bi bi-trash"></i>';
                            $_url = [$_u, 'id' => $this->id];
                            $_options = [
                                'class' => $_class,
                                'data-bs-toggle' => 'tooltip', 
                                'title' => $_title,
                                'data' => [
                                    'confirm' => $_confirm,
                                    'method' => 'post',
                                ],
                            ];
                            break;

                        case 'delete':

                            $_url = $group['config']['delete']['url'] ?? ['delete', 'id' => $this->id];
                            $_caption = '<i class="bi bi-trash"></i>';
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

                        case 'restore':

                            if ($this->isDeleted) {
                                $_url = $group['config']['restore']['url'] ?? ['restore', 'id' => $this->id];
                                $_caption = '<i class="bi bi-recycle"></i>';
                                $_options = [
                                    'class' => 'btn btn-outline-warning',
                                    'data-bs-toggle' => 'tooltip', 
                                    'title' => 'Restore',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to restore this item?',
                                        'method' => 'post',
                                    ],
                                ];
                            } else {
                                $_caption = null;
                            }
                            break;
                        
                        default:
                            $_caption = null;
                            break;
                    }
                    if (isset($_caption))
                        $buttons.= Html::a($_caption, $_url, $_options);
                } elseif (is_array($b)) {
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
            $deletedBadge.= ' <span class="badge bg-danger">Deleted</span>';
        } else {
            $deletedBadge.= '';
        }
        

        return "<div class='hstack gap-2 flex-wrap'>$title $deletedBadge<div class='ms-auto mb-2'>$buttons</div></div>";
    }
}

