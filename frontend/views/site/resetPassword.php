<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grid_12">
    <h1><?= Html::encode($this->title) ?></h1>
	
	<div class="grid_6">
		<p>Please choose your new password:</p>
	</div>

    
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form', 'options' => ['class' => 'bookingForm1 wow fadeIn'],]); ?>

				<div class="grid_6">
					<?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
				</div>	
               		
				<div class="grid_6 advancedSearchButton">
					
					<div class="grid_1">
					</div>
					
					<div class="grid_3">
						<?= Html::submitButton('Save', ['class' => 'btn-big btn-search-main-page', 'name' => 'login-button']) ?>
					</div>
						
					<div class="grid_1">
					</div>
					
                </div>

            <?php ActiveForm::end(); ?>
        
</div>
