<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\ActiveForm;

?>


<?php
    $form = ActiveForm::begin([
    'id' => 'accaunt-form',
    'method' => 'post',
    'action' => ['/accaunt'],
    'options' => ['class' => 'form-horizontal'],
]) ?>
    <?= $form->field($accauntdata, 'username')->textInput(); ?>
    <?= $form->field($accauntdata, 'email')->textInput(); ?>
    
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('CHANGE', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>