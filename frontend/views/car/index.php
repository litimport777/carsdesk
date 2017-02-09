<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\Breadcrumbs;

?>

<?php
 $this->params['breadcrumbs'] = $breadcrumbs;
?>

<div class="grid_12 main-page-list-model">

<?php $cnt = 1;?>
<?php $cntItems = count($modelList);?>

<?php foreach ($modelList as $model):?>
    <?php if((($cnt - 1) % $countItemInColumns == 0) || ($cnt == 1)):?>
        <div class="grid_2">
    <?php endif;?>
			<div>
				<?php echo Html::a($model['model'], Url::to($model['alias'], true));?>
			</div>
    <?php if(($cnt % $countItemInColumns == 0) || ($cnt == $cntItems)):?>
        </div>
    <?php endif;?>
<?php $cnt++;?>
<?php endforeach;?>
</div>


<?php echo $this->render('/_advanced_search', ['modelAdvancedSearchForm'=>$modelAdvancedSearchForm, 'makesSearch'=>$makesSearch]);?>

<div class="grid_12 model-sort">
	<?php echo $sort->link('year') . ' | ' . $sort->link('price');?>
</div>

	
<?php echo $this->render('/_item', ['carsList'=>$carsList, 'pages'=>$pages]);?>


		


