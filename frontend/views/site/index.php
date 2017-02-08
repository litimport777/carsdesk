<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\ActiveForm;


?>
<div id="tabs-1">

<?php
    $form = ActiveForm::begin([
    'id' => 'search-form',
    'method' => 'get',
    'action' => ['/search'],
    'options' => ['class' => 'bookingForm1 wow fadeIn'],
]) ?>
	<div class="grid_3">
		<?= $form->field($model, 'make')->dropDownList($makesSearch, ['class'=>'tmSelect auto']); ?>
	</div>
	
	<div class="grid_3">
		<?= $form->field($model, 'model')->dropDownList([], ['class'=>'tmSelect auto']); ?>
	</div>
	
	<div class="grid_3">
		<?= $form->field($model, 'zip') ?>
	</div>

    <div class="grid_3">
        <?= Html::submitButton('SEARCH', ['class' => 'btn-big btn-search-main-page']) ?>
     </div>
<?php ActiveForm::end() ?>
    
</div>

<div class="clearfix"></div>
<br />

<div class="grid_12 main-page-list-model">
<?php $cnt = 1;?>
<?php $cntItems = count($makes);?>

<?php foreach ($makes as $make):?>
    <?php if((($cnt - 1) % $countItemInColumns == 0) || ($cnt == 1)):?>
        <div class="grid_2">
    <?php endif;?>
		<div>
			<?php echo Html::a($make['make'], Url::to($make['alias'], true));?>
		</div>
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
	
	<br />
	<div><?= $car['tbl_lots_temp_id']; ?></div>

    <div>
		<?php if(!$car['tbl_lots_temp_id']):?>
			<button data-url="<?= $car['id']; ?>" class="save-car">SAVE</button>
			<span style="display: none">success</span>
		<?php else:?>
			<span>success</span>
		<?php endif;?>
		
	</div>
	
    <?php endforeach;?>
</div>


<?php

$this->registerJs('
    $("#searchform-make").on("change", function(){
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
        $("#searchform-model").html(option);
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
