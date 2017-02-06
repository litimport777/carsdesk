<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="post">
    <h2> 
		<?php echo Html::a($model['make'], Url::to($model['alias'], true));?>
	</h2>
	<div><?= $model['model']; ?></div>
	<div><?= $model['year']; ?></div>
	<div><?= $model['price']; ?></div>
</div>