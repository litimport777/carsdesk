<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\ActiveForm;

?>
<div id="tabs-1">

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
    'options' => ['class' => 'bookingForm1 wow fadeIn'],
]) ?>
	
	<div class="grid_12">
	
		<div class="grid_3">
			<?= $form->field($modelAdvancedSearchForm, 'make')->dropDownList($makesSearch, ['class'=>'tmSelect auto']); ?>
		</div>
		
		<div class="grid_3">	
			<?= $form->field($modelAdvancedSearchForm, 'model')->dropDownList($modelsSearch, ['class'=>'tmSelect auto']); ?>
		</div>	
		
		<div class="grid_2">	
			<?= $form->field($modelAdvancedSearchForm, 'body')->dropDownList($modelAdvancedSearchForm::getBodyData(), ['class'=>'tmSelect auto']); ?>
		</div>	
		
		<div class="grid_2">	
			<?= $form->field($modelAdvancedSearchForm, 'color')->dropDownList($modelAdvancedSearchForm::getColorData(), ['class'=>'tmSelect auto']); ?>
		</div>
		
	</div>
	
	<div class="grid_12">
	
		<div class="grid_1">
			<?= $form->field($modelAdvancedSearchForm,'year_from')->dropDownList($modelAdvancedSearchForm::getYearData(),['class'=>'tmSelect auto']);?>
		</div>
		
		<div class="grid_1">	
			<?= $form->field($modelAdvancedSearchForm,'year_to')->dropDownList($modelAdvancedSearchForm::getYearData(),['class'=>'tmSelect auto']);?>
		</div>
	
		<div class="grid_2">
			<?= $form->field($modelAdvancedSearchForm,'meliage_from')->dropDownList($modelAdvancedSearchForm::getMeliageData(),['class'=>'tmSelect auto']);?>
		</div>	
		
		<div class="grid_2">	
			<?= $form->field($modelAdvancedSearchForm,'meliage_to')->dropDownList($modelAdvancedSearchForm::getMeliageData(),['class'=>'tmSelect auto']);?>
		</div>	
						
		<div class="grid_2">
			<?= $form->field($modelAdvancedSearchForm,'price_from')->dropDownList($modelAdvancedSearchForm::getPriceFromData(),['class'=>'tmSelect auto']);?>
		</div>
		
		<div class="grid_2">	
			<?= $form->field($modelAdvancedSearchForm,'price_to')->dropDownList($modelAdvancedSearchForm::getPriceToData(),['class'=>'tmSelect auto']);?>
		</div>
		
	</div>
	
	<div class="grid_12">
	
		<div class="grid_3">
			<?= $form->field($modelAdvancedSearchForm,'transmission')->dropDownList($modelAdvancedSearchForm::getTransmissionData(),['class'=>'tmSelect auto']);?>
		</div>
		
		<div class="grid_3">	
			<?= $form->field($modelAdvancedSearchForm,'engine')->dropDownList($modelAdvancedSearchForm::getEngineData(),['class'=>'tmSelect auto']);?>
		</div>
		
		<div class="grid_4">	
			<?= $form->field($modelAdvancedSearchForm,'zip');?>
		</div>
		
	</div>

    <div class="grid_12">
	
		<div class="grid_3">
		</div>
		
		<div class="grid_4">
			<?= Html::submitButton('SEARCH', ['class' => 'btn-big btn-search-main-page']) ?>
		</div>
		
		<div class="grid_3">
		</div>
		
    </div>
<?php ActiveForm::end() ?>

</div>

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