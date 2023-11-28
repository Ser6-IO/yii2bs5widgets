<?php

namespace ser6io\yii2bs5widgets;

use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

class DetailView extends \yii\widgets\DetailView
{
    public $options = ['class' => 'detail-view', 'tag' => 'div'];

    public $template = "<div class='card p-2 mb-2'><small class='text-muted'><span{captionOptions}>{label}</span></small><div{contentOptions}>{value}&nbsp;</div></div>";

    public $rows;

    public $defaultColClass;

    /**
     * @inheritdoc
     * Modified to use Bootstrap 5 Rows and Columns
     */
    public function run()
    {
        $rows = [];
        $i = 0;
        if ($this->rows === null) {
            
            foreach ($this->attributes as $attribute) {
                $rows[] = $this->renderAttribute($attribute, $i++);
            }
            
        } else {

            foreach ($this->rows as $r => $row) {

                $defaultColClass = $this->defaultColClass ?? 'col-lg-' . round(12/count($row));
                $cols = [];
                $i = 0;
                foreach ($row as $attribute) {
    
                    $attribute = $this->normalizeColAttribute($attribute);
                    if ($attribute === false) {
                        continue;
                    }
                    
                    $colClass = $attribute['col-class'] ?? $defaultColClass;    
                    $cols[] = "<div class='$colClass'>" . $this->renderAttribute($attribute, $i++) . "</div>";
                }
                $rows[] = Html::tag('div', implode("\n", $cols), ['class' => 'row']);
                    
            }
            
        }
        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'table');
        echo Html::tag($tag, implode("\n", $rows), $options);
    }

    /**
     * Normalizes the Columns attributes.
     * @throws InvalidConfigException
     */
    protected function normalizeColAttribute($attribute)
    {

        if (is_string($attribute)) {
            if (!preg_match('/^([^:]+)(:(\w*))?(:(.*))?$/', $attribute, $matches)) {
                throw new InvalidConfigException('The attribute must be specified in the format of "attribute", "attribute:format" or "attribute:format:label"');
            }
            $attribute = [
                'attribute' => $matches[1],
                'format' => isset($matches[3]) ? $matches[3] : 'text',
                'label' => isset($matches[5]) ? $matches[5] : null,
            ];
        }

        if (!is_array($attribute)) {
            throw new InvalidConfigException('The attribute configuration must be an array.');
        }

        if (isset($attribute['visible']) && !$attribute['visible']) {
            return false;
        }

        if (!isset($attribute['format'])) {
            $attribute['format'] = 'text';
        }

        if (isset($attribute['attribute'])) {
            $attributeName = $attribute['attribute'];
            if (!isset($attribute['label'])) {
                $attribute['label'] = $this->model instanceof Model ? $this->model->getAttributeLabel($attributeName) : Inflector::camel2words($attributeName, true);
            }
            if (!array_key_exists('value', $attribute)) {
                $attribute['value'] = ArrayHelper::getValue($this->model, $attributeName);
            }
        } elseif (!isset($attribute['label']) || !array_key_exists('value', $attribute)) {
            throw new InvalidConfigException('The attribute configuration requires the "attribute" element to determine the value and display label.');
        }

        if ($attribute['value'] instanceof \Closure) {
            $attribute['value'] = call_user_func($attribute['value'], $this->model, $this);
        }

        return $attribute;
            
    }
}