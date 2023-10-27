<?php
/**
 * CreatedByWidget class file.
 * Input: $model
 * Outputs the name of the user who created the record, and the date and time it was created and updated.
 * 
 */

namespace ser6io\yii2bs5widgets;

use Yii;
use yii\base\Widget;

class CreatedByWidget extends Widget
{
    public $model;
    public $class = 'text-secondary';

    public function run()
    {
        $created_at = Yii::$app->formatter->asDateTime($this->model->created_at);
        $created_by = isset($this->model->createdBy->email) ? 'by ' . $this->model->createdBy->email : '';
        
        $updated_at = Yii::$app->formatter->asDateTime($this->model->updated_at);
        $updated_by = isset($this->model->updatedBy->email) ? 'by ' . $this->model->updatedBy->email : '';

        return "<p class='$this->class'>
                    <small>
                        <em>
                            Created: $created_at $created_by - Last updated: $updated_at $updated_by
                        </em>
                    </small>
                </p>";
    }
}