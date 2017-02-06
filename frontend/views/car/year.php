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
<?php $cntItems = count($yearList);?>

<?php foreach ($yearList as $year):?>
    <?php if((($cnt - 1) % $countItemInColumns == 0) || ($cnt == 1)):?>
        <div>
    <?php endif;?>

    <?php echo Html::a($year['name'], Url::to($year['alias'], true));?>

    <?php if(($cnt % $countItemInColumns == 0) || ($cnt == $cntItems)):?>
        </div>
    <?php endif;?>
<?php $cnt++;?>
<?php endforeach;?>
</div>

<hr />

<?php echo $this->render('/_advanced_search');?>

<hr />

<?php echo $sort->link('price');?>
<hr />

<?php
echo ListView::widget([
    'dataProvider' => $carsList,
    'itemView' => '/_item',
]);
?>


