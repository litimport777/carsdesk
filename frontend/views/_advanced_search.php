<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\ActiveForm;

?>

<?php 
	if(isset($modelSearch)){
		$modelsSearch = $modelSearch;
	}else{
		$modelsSearch = [];
	}
	
	$form = ActiveForm::begin([
    'id' => 'search-form',
    'method' => 'get',
    'action' => ['/search'],
    'options' => ['class' => 'form-horizontal'],
]) ?>
    <?= $form->field($modelAdvancedSearchForm, 'make')->dropDownList($makesSearch); ?>
    <?= $form->field($modelAdvancedSearchForm, 'model')->dropDownList($modelsSearch); ?>
    <?= $form->field($modelAdvancedSearchForm, 'zip') ?>
	
	<?= $form->field($modelAdvancedSearchForm, 'body')->dropDownList($modelAdvancedSearchForm::getBodyData()); ?>
	<?= $form->field($modelAdvancedSearchForm, 'color')->dropDownList($modelAdvancedSearchForm::getColorData()); ?>
	<?= $form->field($modelAdvancedSearchForm, 'transmission')->dropDownList($modelAdvancedSearchForm::getTransmissionData()); ?>
	<?= $form->field($modelAdvancedSearchForm, 'engine')->dropDownList($modelAdvancedSearchForm::getEngineData()); ?>
	
	<?= $form->field($modelAdvancedSearchForm, 'meliage_from')->dropDownList($modelAdvancedSearchForm::getMeliageData()); ?>
	<?= $form->field($modelAdvancedSearchForm, 'meliage_to')->dropDownList($modelAdvancedSearchForm::getMeliageData()); ?>
	
	<?= $form->field($modelAdvancedSearchForm, 'year_from')->dropDownList($modelAdvancedSearchForm::getYearData()); ?>
	<?= $form->field($modelAdvancedSearchForm, 'year_to')->dropDownList($modelAdvancedSearchForm::getYearData()); ?>
	
	<?= $form->field($modelAdvancedSearchForm, 'price_from')->dropDownList($modelAdvancedSearchForm::getPriceFromData()); ?>
	<?= $form->field($modelAdvancedSearchForm, 'price_to')->dropDownList($modelAdvancedSearchForm::getPriceToData()); ?>
	

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('SEARCH', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>

<?php

$this->registerJs('
    $("#searchadvancedform-make").on("change", function(){
        var make = $(this).val();
        sendRequest(make);
    });

    function sendRequest(make){
        $.post("/site/getmodels", {"make": make}, function(data){
            var result = $.parseJSON(data);
            renderModel(result);
        });
    };

    function renderModel(result){
        var option = "";

        for (key in result){
            option += "<option value=\"" + key + "\">" + key + "</option>";
        }
        $("#searchadvancedform-model").html(option);
    }
	
	$(".save-car").each(function(idx, el){
        $(this).on("click", function(event){
            var id = $(this).data().url;
            sendRequestSaveData(id);
        });
    });

    function sendRequestSaveData(id){
        $.post("/site/save-data", {"id": id}, function(data){
            var result = $.parseJSON(data);
            if(result == true){
                var current =$("[data-url=" + id + "]");
                current.next().show();
                current.hide();
            }
        });
    }
')

?>