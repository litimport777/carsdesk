<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\Breadcrumbs;

?>

<?php
 $this->params['breadcrumbs'] = $breadcrumbs;
?>


<div class="wrapper2 grid_11 news-items-list">
	<div class="heading1 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
		<h2><?= $model['name'];?></h2>
	</div>
	<div>
		<?= Html::img(Yii::$app->urlManagerBackend->createUrl('/uploads/' . $model['img']),['class'=>'wow fadeIn']);?>
	</div>
	<br />
	<div>
		<?= $model['data'];?>
	</div>
</div>