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

<div class="clearfix"></div>
<br />
<div  class="wrapper2 grid_11">
		<?php if($newsList):?>
		<?php $cntNews = 1;?>
		<?php $cntNewsItems = count($newsList);?>
			<?php foreach($newsList as $value):?>
			
				<?php if((($cntNews - 1) % $countNewsItemInColumns == 0) || ($cntNews == 1)):?>
					<div  class="grid_5">
				<?php endif;?>
					
					<div class="grid_11 news-item-index-page">
						<h4 class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
							<?php echo Html::a($value['name'], '#');?>
						</h4>
						<div class="news-index-left">
							<?php echo Html::a(Html::img(Yii::$app->urlManagerBackend->createUrl('/uploads/' . $value['img']), 
										['class' => 'wow fadeIn img-news-index-page', 'width' => '60%', 'height' => '60%']), '#');?>
						</div>
						<div class="news-index-right">
							<?php echo Html::a(mb_substr($value['data'], 0, 260) . '...', '#');?>
						</div>
						<div class="clearfix"></div>
					</div>
									
				<?php if(($cntNews % $countNewsItemInColumns == 0) || ($cntNews == $cntNewsItems)):?>
					</div>
				<?php endif;?>
				<?php $cntNews++;?>
			<?php endforeach;?>
		<?php endif;?>
</div>
<div class="clearfix"></div>
<br />



<?php //var_dump($carsRandom);?>
<div class="wrapper2 grid_12">
	<div class="border-wrapper1 wrapper3">
        <div class="row">	
			<?php for($i = 0; $i <= 2; $i++): ?>
				<div class="grid_4 main-page-grid">
					
					<h4 class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
						<?php echo Html::a(ucwords(strtolower(substr($carsRandom[$i]['make'] . ' ' . $carsRandom[$i]['model'], 0, 30))), Url::to($carsRandom[$i]['alias'], true));?>
					</h4>
					<div class="item-left">
						<?php echo Html::img($this->context->getImageUrl(1, $carsRandom[$i]['hash'], $carsRandom[$i]['images_date'], true),
						['class' => 'wow fadeIn']);?>
					</div>
		
					<div class="item-right">
						<div class="info wow fadeIn" data-wow-duration="1s" data-wow-delay=".2s">
					
							<span class="first">Mileage: <span class="highlighted"><?= $carsRandom[$i]['odometer']?> km</span></span><br />
							<span class="second">Year: <span class="highlighted"><?= $carsRandom[$i]['year']; ?></span></span><br />
							<span class="first">Price:</span> <span class="second">$<?= $carsRandom[$i]['price']; ?></span>
																
						</div>
						
					</div>
		
					<div class="clearfix"></div>
					
					<div class="info2 wow fadeIn item-image-position" data-wow-duration="1s" data-wow-delay=".3s">
							<?php echo Html::a('MORE', Url::to($carsRandom[$i]['alias'], true), ['class' =>'btn btn-big btn-item-link']);?>
							
							<span class="icon-item-save-container" href="#" onclick="return false">
							  <?php if(!$carsRandom[$i]['tbl_lots_temp_id']):?>
									<span class="save-car" data-url="<?= $carsRandom[$i]['id']; ?>">
										<img src="/img/w128h128139396832520.png"  class="save-icon" />
										<span class="save-icon-text">save</span>
									</span>
									<img src="/img/package_fovourite.png" style="display: none" class="save-icon" />
							  <?php else:?>
									<img src="/img/package_fovourite.png" class="save-icon" />
							  <?php endif;?>
							</span>
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
				<div class="grid_4 main-page-grid">
					
					<h4 class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
						<?php echo Html::a(ucwords(strtolower(substr($carsRandom[$i]['make'] . ' ' . $carsRandom[$i]['model'], 0, 30))), Url::to($carsRandom[$i]['alias'], true));?>
					</h4>
					<div class="item-left">
						<?php echo Html::img($this->context->getImageUrl(1, $carsRandom[$i]['hash'], $carsRandom[$i]['images_date'], true),
						['class' => 'wow fadeIn']);?>
					</div>
		
					<div class="item-right">
						<div class="info wow fadeIn" data-wow-duration="1s" data-wow-delay=".2s">
					
							<span class="first">Mileage: <span class="highlighted"><?= $carsRandom[$i]['odometer']?> km</span></span><br />
							<span class="second">Year: <span class="highlighted"><?= $carsRandom[$i]['year']; ?></span></span><br />
							<span class="first">Price:</span> <span class="second">$<?= $carsRandom[$i]['price']; ?></span>
							
																
						</div>
						
					</div>
		
					<div class="clearfix"></div>
					
					<div class="info2 wow fadeIn item-image-position" data-wow-duration="1s" data-wow-delay=".3s">
							<?php echo Html::a('MORE', Url::to($carsRandom[$i]['alias'], true), ['class' =>'btn btn-big btn-item-link']);?>
							
							<span class="icon-item-save-container" href="#" onclick="return false">
							  <?php if(!$carsRandom[$i]['tbl_lots_temp_id']):?>
									<span class="save-car" data-url="<?= $carsRandom[$i]['id']; ?>">
										<img src="/img/w128h128139396832520.png"  class="save-icon" />
										<span class="save-icon-text">save</span>
									</span>
									<img src="/img/package_fovourite.png" style="display: none" class="save-icon" />
							  <?php else:?>
									<img src="/img/package_fovourite.png" class="save-icon" />
							  <?php endif;?>
							</span>
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
