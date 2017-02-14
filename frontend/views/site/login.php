<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grid_6">
    <h1><?= Html::encode($this->title) ?></h1>
	
	<div class="grid_6">
		<p>Please fill out the following fields to login:</p>
	</div>
    
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'bookingForm1 wow fadeIn'],]); ?>
				
				
				<div class="grid_6">
					<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
				</div>
				<br />
				
				<div class="grid_6">
					<?= $form->field($model, 'password')->passwordInput() ?>
				</div>
							
				<div class="grid_6">	
					<?= $form->field($model, 'rememberMe')->checkbox(['style'=>'width: 20px; height: 20px;']) ?>
				</div>	
				
				<div class="grid_6">
					<div style="color:#999;margin:1em 0">
						If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
					</div>
				</div>

                <div class="grid_6 advancedSearchButton">
					
					<div class="grid_1">
					</div>
					
					<div class="grid_3">
						<?= Html::submitButton('Login', ['class' => 'btn-big btn-search-main-page', 'name' => 'login-button']) ?>
					</div>
						
					<div class="grid_1">
					</div>
					
                </div>

            <?php ActiveForm::end(); ?>
       
</div>
