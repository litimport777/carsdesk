<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grid_8">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

   
            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'options' => ['class' => 'bookingForm1 wow fadeIn'],]); ?>
				
				<div class="grid_6">
					<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
				</div>
				<div class="clearfix"></div>
				
				<div class="grid_6">
					<?= $form->field($model, 'email') ?>
				</div>
				
				<div class="grid_6">
					<?= $form->field($model, 'password')->passwordInput() ?>
				</div>

               				
				<div class="grid_6 advancedSearchButton">
					
					<div class="grid_1">
					</div>
					
					<div class="grid_3">
						<?= Html::submitButton('Signup', ['class' => 'btn-big btn-search-main-page', 'name' => 'login-button']) ?>
					</div>
						
					<div class="grid_2">
					</div>
					
                </div>

            <?php ActiveForm::end(); ?>
        
</div>
