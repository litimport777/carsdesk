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
		
							
			

<div class="grid_4">
	
	
		<h4 class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
			<?php echo Html::a(ucwords(strtolower(substr($model['make'] . ' ' . $model['model'], 0, 30))), Url::to($model['alias'], true));?>
		</h4>
		<div class="item-left">
			<?php echo Html::img($this->context->getImageUrl(1, $model['hash'], $model['images_date'], true),
			['class' => 'wow fadeIn']);?>
		</div>
		
		<div class="item-right">
			<div class="info wow fadeIn" data-wow-duration="1s" data-wow-delay=".2s">
		
				<span class="first">Mileage: <span class="highlighted"><?= $model['odometer']?> km</span></span><br />
				<span class="second">Year: <span class="highlighted"><?= $model['year']; ?></span></span><br />
				<span class="first">Price:</span> <span class="second">$<?= $model['price']; ?></span>
				
				
						
			</div>
			
		</div>
		
		<div class="clearfix"></div>
		
		<div class="info2 wow fadeIn item-image-position" data-wow-duration="1s" data-wow-delay=".3s">
				<?php echo Html::a('MORE', Url::to($model['alias'], true), ['class' =>'btn btn-big btn-item-link']);?>
				
				<span class="icon-item-save-container" href="#" onclick="return false">
				  <?php if(!$model['tbl_lots_temp_id']):?>
						<span class="save-car" data-url="<?= $model['id']; ?>">
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









