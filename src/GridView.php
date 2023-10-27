<?php 

namespace ser6io\yii2bs5widgets;

class GridView extends \yii\grid\GridView 
{   
    public $tableOptions = ['class' => 'table table-hover'];

    public $dataColumnClass = 'ser6io\yii2bs5widgets\DataColumn';

    public $pager = [
        'options' => ['class' => 'pagination my-0'],
        'linkContainerOptions' => ['class' => 'page-item'],
        'linkOptions' => ['class' => 'page-link'],
        'disabledListItemSubTagOptions' => ['class' => 'page-link'],
        'firstPageLabel' => '&lt;',
        'lastPageLabel'  => '&gt;',
        'maxButtonCount' => 5,
    ];

    
    public $layout = "{items}<div class='d-sm-flex justify-content-between align-items-center'>{summary}{pager}</div>";
    
    public $filterPosition = self::FILTER_POS_HEADER;

    // override styling of your sorter
    //public $sorter = ['options' => ['class' => 'sorter']];

    // override other styles through these options
    //public $options = ['class' => 'grid-view'];
  //  public $headerRowOptions = ['class' => 'table-light'];
 //   public $filterRowOptions = ['class' => 'table-light'];
    public $footerRowOptions = [];
    public $rowOptions = [];
        
    public $options = ['style'=>'overflow: auto;']; // word-wrap: break-word;

}