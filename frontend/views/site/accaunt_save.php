<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\ActiveForm;

?>


<div class="grid_12 accaunt-save-data main-page-list-model">

<?php $cnt = 1;?>
<?php $cntItems = count($accauntdata);?>
<?php $countItemInColumns = 3;?>


<?php foreach ($accauntdata as $model):?>
    <?php if((($cnt - 1) % $countItemInColumns == 0) || ($cnt == 1)):?>
        <div class="grid_12">
    <?php endif;?>
	
	
			<div class="grid_3 deleteSaveAuto">
				<div class="box1">
				
					<h4 class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
						<?php echo Html::a($model['make'] . ' ' . $model['model'], Url::to($model['alias'], true));?>
					</h4>
					
					<?php echo Html::img($this->context->getImageUrl(1, $model['hash'], $model['images_date'], true),
						['class' => 'wow fadeIn']);?>
					<div class="info wow fadeIn" data-wow-duration="1s" data-wow-delay=".2s">
					
						<span class="first">Mileage: <span class="highlighted"><?= $model['odometer']?> km</span></span>
						<span class="second">Year: <span class="highlighted"><?= $model['year']; ?></span></span>
						<div class="clearfix"></div>
					
					</div>
					
					<div class="info2 wow fadeIn" data-wow-duration="1s" data-wow-delay=".3s">
						<div class="price">
						  <span class="first">Price:</span>
						  <span class="second">$<?= $model['price']; ?></span>
						</div>
						<a class="btn-default delete-car" href="#" onclick="return false" data-url="<?= $model['tbl_lots_temp_id']; ?>">
							DELETE
						</a>
						<div class="clearfix"></div>
					</div>
										
				</div>
			</div>
			
			
    <?php if(($cnt % $countItemInColumns == 0) || ($cnt == $cntItems)):?>
        </div>
    <?php endif;?>
<?php $cnt++;?>
<?php endforeach;?>
</div>



<?php

$this->registerJs('
    	
	$(".delete-car").each(function(idx, el){
        $(this).on("click", function(event){
            var id = $(this).data().url;
            sendRequestSaveData(id);
        });
    });

    function sendRequestSaveData(id){
        $.post("/site/delete-data", {"id": id}, function(data){
            var result = $.parseJSON(data);
            if(result == true){
                var current =$("[data-url=" + id + "]");
                current.parents(".deleteSaveAuto").remove();
            }
        });
    }
')

?>