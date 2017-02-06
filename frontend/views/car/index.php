<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\ListView;
use yii\widgets\Breadcrumbs;

?>
<hr />

<?php
 $this->params['breadcrumbs'] = $breadcrumbs;
?>

<div>

<?php $cnt = 1;?>
<?php $cntItems = count($modelList);?>

<?php foreach ($modelList as $model):?>
    <?php if((($cnt - 1) % $countItemInColumns == 0) || ($cnt == 1)):?>
        <div>
    <?php endif;?>

    <?php echo Html::a($model['model'], Url::to($model['alias'], true));?>

    <?php if(($cnt % $countItemInColumns == 0) || ($cnt == $cntItems)):?>
        </div>
    <?php endif;?>
<?php $cnt++;?>
<?php endforeach;?>
</div>

<hr />

<?php echo $sort->link('year') . ' | ' . $sort->link('price');?>

<hr />

<?php
echo ListView::widget([
    'dataProvider' => $carsList,
    'itemView' => '/_item',
]);
?>

