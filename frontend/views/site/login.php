<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grid_12">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'bookingForm1 wow fadeIn'],]); ?>
				
				
				<div class="grid_12">
					<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
				</div>
				
				<div class="grid_12">
					<?= $form->field($model, 'password')->passwordInput() ?>
				</div>
							
				<div class="grid_2">	
					<?= $form->field($model, 'rememberMe')->checkbox() ?>
				</div>	
				
				<div class="grid_12">
					<div style="color:#999;margin:1em 0">
						If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
					</div>
				</div>

                <div class="grid_12 advancedSearchButton">
					
					<div class="grid_3">
					</div>
					
					<div class="grid_4">
						<?= Html::submitButton('Login', ['class' => 'btn-big btn-search-main-page', 'name' => 'login-button']) ?>
					</div>
						
					<div class="grid_3">
					</div>
					
                </div>

            <?php ActiveForm::end(); ?>
       
</div>
