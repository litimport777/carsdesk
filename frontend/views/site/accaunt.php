<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\ActiveForm;

?>

<div class="grid_12">

	<div class="heading1 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
              <h2>ACCAUNT</h2>
    </div>


<?php
    $form = ActiveForm::begin([
    'id' => 'accaunt-form',
    'method' => 'post',
    'action' => ['/accaunt'],
    'options' => ['class' => 'bookingForm1 wow fadeIn'],
]) ?>
    <?= $form->field($accauntdata, 'username')->textInput(); ?>
    <?= $form->field($accauntdata, 'email')->textInput(); ?>
    
    <div class="grid_12 advancedSearchButton">
		
		<div class="grid_3">
		</div>
		
        <div class="grid_4">
            <?= Html::submitButton('CHANGE', ['class' => 'btn-big btn-search-main-page']) ?>
        </div>
		
		<div class="grid_3">
		</div>
		
    </div>
<?php echo $form->errorSummary($accauntdata);?>
<?php ActiveForm::end() ?>
</div>