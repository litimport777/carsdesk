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
    'action' => ['/car/search'],
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

<?php //var_dump($carsRandom);?>
<div class="wrapper2 grid_12">
	<div class="border-wrapper1 wrapper3">
        <div class="row">	
			<?php for($i = 0; $i <= 2; $i++): ?>
				<div class="grid_4">
					<div class="box1">
					
						<h4 class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
							<?php echo Html::a($carsRandom[$i]['make'] . ' ' . $carsRandom[$i]['model'], Url::to($carsRandom[$i]['alias'], true));?>
						</h4>
						
						<?php echo Html::img($this->context->getImageUrl(1, $carsRandom[$i]['hash'], $carsRandom[$i]['images_date'], true),
							['class' => 'wow fadeIn']);?>
						<div class="info wow fadeIn" data-wow-duration="1s" data-wow-delay=".2s">
						
							<span class="first">Mileage: <span class="highlighted"><?= $carsRandom[$i]['odometer']?> km</span></span>
							<span class="second">Year: <span class="highlighted"><?= $carsRandom[$i]['year']; ?></span></span>
							<div class="clearfix"></div>
						
						</div>
						
						<div class="info2 wow fadeIn" data-wow-duration="1s" data-wow-delay=".3s">
							<div class="price">
							  <span class="first">Price:</span>
							  <span class="second">$<?= $carsRandom[$i]['price']; ?></span>
							</div>
							<a class="btn-default" href="#" onclick="return false">
							  <?php if(!$carsRandom[$i]['tbl_lots_temp_id']):?>
									<span  data-url="<?= $carsRandom[$i]['id']; ?>" class="save-car">SAVE</span>
									<span style="display: none">SUCCESS</span>
							  <?php else:?>
									<span>SUCCESS</span>
							  <?php endif;?>
							</a>
							<div class="clearfix"></div>
                        </div>						
						
					</div>
				</div>
			<?php endfor;?>
		</div>
    </div>
</div>

<div class="wrapper2 grid_12">
	<div class="border-wrapper1 wrapper3">
        <div class="row">	
			<?php for($i = 3; $i <= 5; $i++): ?>
				<div class="grid_4">
					<div class="box1">
					
						<h4 class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
							<?php echo Html::a($carsRandom[$i]['make'] . ' ' . $carsRandom[$i]['model'], Url::to($carsRandom[$i]['alias'], true));?>
						</h4>
						
						<?php echo Html::img($this->context->getImageUrl(1, $carsRandom[$i]['hash'], $carsRandom[$i]['images_date'], true),
							['class' => 'wow fadeIn']);?>
						<div class="info wow fadeIn" data-wow-duration="1s" data-wow-delay=".2s">
						
							<span class="first">Mileage: <span class="highlighted"><?= $carsRandom[$i]['odometer']?> km</span></span>
							<span class="second">Year: <span class="highlighted"><?= $carsRandom[$i]['year']; ?></span></span>
							<div class="clearfix"></div>
						
						</div>
						
						<div class="info2 wow fadeIn" data-wow-duration="1s" data-wow-delay=".3s">
							<div class="price">
							  <span class="first">Price:</span>
							  <span class="second">$<?= $carsRandom[$i]['price']; ?></span>
							</div>
							<a class="btn-default" href="#" onclick="return false">
							  <?php if(!$carsRandom[$i]['tbl_lots_temp_id']):?>
									<span  data-url="<?= $carsRandom[$i]['id']; ?>" class="save-car">SAVE</span>
									<span style="display: none">SUCCESS</span>
							  <?php else:?>
									<span>SUCCESS</span>
							  <?php endif;?>
							</a>
							<div class="clearfix"></div>
                        </div>
											
					</div>
				</div>
			<?php endfor;?>
		</div>
    </div>
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
