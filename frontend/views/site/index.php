<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\ActiveForm;

?>
<div class="site-index">
    <h1>All cars. One place. Simple Search.</h1>

<?php
    $form = ActiveForm::begin([
    'id' => 'search-form',
    'method' => 'get',
    'action' => ['/search'],
    'options' => ['class' => 'form-horizontal'],
]) ?>
    <?= $form->field($model, 'make')->dropDownList($makesSearch); ?>
    <?= $form->field($model, 'model') ?>
    <?= $form->field($model, 'zip') ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>

    <hr />

</div>

<div>
<?php $cnt = 1;?>
<?php $cntItems = count($makes);?>

<?php foreach ($makes as $make):?>
    <?php if((($cnt - 1) % $countItemInColumns == 0) || ($cnt == 1)):?>
        <div>
    <?php endif;?>

    <?php echo Html::a($make['make'], Url::to($make['alias'], true));?>

    <?php if(($cnt % $countItemInColumns == 0) || ($cnt == $cntItems)):?>
        </div>
    <?php endif;?>
<?php $cnt++;?>
<?php endforeach;?>
</div>


<div>
    <?php foreach($carsRandom as $car): ?>
    <h2>
		<?php echo Html::a($car['make'], Url::to($car['alias'], true));?>
	</h2>
	<div><?= $car['model']; ?></div>
	<div><?= $car['year']; ?></div>
	<div><?= $car['price']; ?></div>
		
    <?php endforeach;?>
</div>
