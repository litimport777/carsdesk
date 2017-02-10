<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>


<?php $countAll = $carsList->count;?>
<?php $carsDataList = $carsList->getModels();?>
<?php foreach ($carsDataList as $model):?>
		
		
<?php if(($this->context->modelCounter == 1) || (($this->context->modelCounter - 1) % $this->context->countItemInColumns == 0)):?>
<div class="wrapper2 grid_12">
	<div class="border-wrapper1 wrapper3">
		 <div class="row">      
			<?php endif;?>	
		
							
			

<div class="grid_3">
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
			<a class="btn-default" href="#" onclick="return false">
			  <?php if(!$model['tbl_lots_temp_id']):?>
					<span  data-url="<?= $model['id']; ?>" class="save-car">SAVE</span>
					<span style="display: none">SUCCESS</span>
			  <?php else:?>
					<span>SUCCESS</span>
			  <?php endif;?>
			</a>
			<div class="clearfix"></div>
		</div>
							
	</div>
</div>



<?php if(($this->context->modelCounter == $countAll) || ($this->context->modelCounter % $this->context->countItemInColumns == 0)):?>
		</div>
	</div>
</div>
<?php endif;?>
<?php $this->context->modelCounter++;?>


<?php endforeach;?>

<div class="grid_12 pagination-wraper">

<?php

echo LinkPager::widget([
    'pagination' => $pages,
]);
?>
</div>









