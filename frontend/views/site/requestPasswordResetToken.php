<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grid_12">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out your email. A link to reset password will be sent there.</p>

    
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form', 'options' => ['class' => 'bookingForm1 wow fadeIn'],]); ?>
				
				<div class="grid_12">
					<?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
				</div>

               				
				<div class="grid_12 advancedSearchButton">
					
					<div class="grid_3">
					</div>
					
					<div class="grid_4">
						<?= Html::submitButton('Send', ['class' => 'btn-big btn-search-main-page', 'name' => 'login-button']) ?>
					</div>
						
					<div class="grid_3">
					</div>
					
                </div>

            <?php ActiveForm::end(); ?>
       
</div>
