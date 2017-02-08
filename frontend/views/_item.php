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
	<br />
	<div><?= $model['tbl_lots_temp_id']; ?></div>
	<div>
		<?php if(!$model['tbl_lots_temp_id']):?>
			<button data-url="<?= $model['id']; ?>" class="save-car">SAVE</button>
			<span style="display: none">success</span>
		<?php else:?>
			<span>success</span>
		<?php endif;?>
		
	</div>
</div>