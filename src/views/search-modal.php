<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="form-floating mt-3 field-<?= $inputId /* 'required' */ ?>">
    
    <div id="<?= $inputId ?>-card" class="card p-3"></div>

    <?= Html::activeHiddenInput($model, $attribute) ?>
    <div class="invalid-feedback"></div>
    
</div>
    
 <!-- Modal -->
 <div class="modal fade" id="<?= $inputId ?>-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input id="<?= $inputId ?>-search-input" type="text" class="form-control" placeholder="Start typing the name of the <?= $label ?> to search for it">
                </div>      
                <div id="<?= $inputId ?>-search-results" class="list-group"></div>    
            </div>
            <div class="modal-footer">
                <small class="me-auto">If the <?= $label ?> is not found, you can <a href="<?= Url::to($createUrl) ?>">create it</a></small>.
            </div>
        </div>
    </div>
</div>
