<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\Breadcrumbs;
use dosamigos\gallery\Gallery;


use edofre\sliderpro\models\Slide;
use edofre\sliderpro\models\slides\Caption;
use edofre\sliderpro\models\slides\Image;
use edofre\sliderpro\models\slides\Layer;


//var_dump($car);

//$data = Yii::$app->db->createCommand('SELECT additional FROM {{tbl_lot_descriptions}} WHERE id = :id', [':id'=>$car['id']])->queryScalar();
//$result = gzinflate($data);
//echo (unserialize($result));
?>


<?php
	$slides = [];
	$thumbnails = [];
	for($i = 1; $i <= $car['count_images'];$i++){
		$slides[($i - 1)] = 
			 new Slide([
				'items' => [
					new Image(['src' => $this->context->getImageUrl($i, $car['hash'], $car['images_date'], false)]),
				],
			]);
		
		$thumbnails[($i - 1)] =  new \edofre\sliderpro\models\Thumbnail(['tag' => 'img', 'htmlOptions' => ['src' => $this->context->getImageUrl($i, $car['hash'], $car['images_date'], true)]]);
	}	
?>
	

<?php
 $this->params['breadcrumbs'] = $breadcrumbs;
?>
<section id="content">
  <div class="width-wrapper width-wrapper__inset1">
    <div class="wrapper1 wrapper10">
      <div class="container">
		<div class="row">
          <div class="grid_12">

	<div class="heading1 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
              <h2><?= $car['make']; ?> <?= $car['model'];?></h2>
    </div>
		
	<div class="grid_12">
		<div class="grid_6">
			
			<?= \edofre\sliderpro\SliderPro::widget([
				'id'            => 'my-slider',
				'slides'        => $slides,
				'thumbnails'    => $thumbnails,
				'sliderOptions' => [
					'width'  => 960,
					'height' => 500,
					'arrows' => true,
					'init'   => new \yii\web\JsExpression("
						function() {
							console.log('slider is initialized');
						}
					"),
				],
			]);
			?>
			
		</div>
		
		<div class="grid_5 item-page">
		
		
		<div class="grid_12">
			<span class="icon-item-item-save-container" href="#" onclick="return false">
			  <?php if(!$car['tbl_lots_temp_id']):?>
					<span class="save-car" data-url="<?= $car['id']; ?>">
						<img src="/img/w128h128139396832520.png"  class="save-icon" />
						<span class="save-icon-text">save</span>
					</span>
					<img src="/img/package_fovourite.png" style="display: none" class="save-icon" />
			  <?php else:?>
					<img src="/img/package_fovourite.png" class="save-icon" />
			  <?php endif;?>
			</span>
		</div>
		
			<?php //if($car['vin']):?>
				<div class="grid_12">
					<div class="grid_1">
						<h4 class="wow fadeIn animated" data-wow-duration="1s" data-wow-delay="0.1s" 
						style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeIn;"> 
							vin
						</h4>
					</div>
					<div class="grid_4 information-item-pape-value">
						<?= $car['vin']; ?>
					</div>
				</div>
			<?php //endif;?>
				
			<?php //if($car['price']):?>	
				<div class="grid_12 information-item-pape">
					<div class="grid_1">
						<h4 class="wow fadeIn animated" data-wow-duration="1s" data-wow-delay="0.1s" 
						style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeIn;"> 
							price
						</h4>
					</div>
					<div class="grid_4 information-item-pape-value">
						<?= $car['price']; ?>
					</div>
				</div>
			<?php //endif;?>
			
			<?php //if($car['odometer']):?>	
				<div class="grid_12 information-item-pape">
					<div class="grid_1">
						<h4 class="wow fadeIn animated" data-wow-duration="1s" data-wow-delay="0.1s" 
						style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeIn;"> 
							mileage
						</h4>
					</div>
					<div class="grid_4 information-item-pape-value">
						<?= $car['odometer']; ?>
					</div>
				</div>
			<?php //endif;?>
			
			<?php //if($car['year']):?>
				<div class="grid_12 information-item-pape">
					<div class="grid_1">
						<h4 class="wow fadeIn animated" data-wow-duration="1s" data-wow-delay="0.1s" 
						style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeIn;"> 
							year
						</h4>
					</div>
					<div class="grid_4 information-item-pape-value">
						<?= $car['year']; ?>
					</div>
				</div>
			<?php //endif;?>
			
			<?php //if($car['fuel']):?>
				<div class="grid_12 information-item-pape">
					<div class="grid_1">
						<h4 class="wow fadeIn animated" data-wow-duration="1s" data-wow-delay="0.1s" 
						style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeIn;"> 
							fuel
						</h4>
					</div>
					<div class="grid_4 information-item-pape-value">
						<?= $car['fuel']; ?>
					</div>
				</div>
			<?php //endif;?>
			
			<?php //if($car['transmission']):?>
				<div class="grid_12 information-item-pape">
					<div class="grid_1">
						<h4 class="wow fadeIn animated" data-wow-duration="1s" data-wow-delay="0.1s" 
						style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeIn;"> 
							transmission
						</h4>
					</div>
					<div class="grid_4 information-item-pape-value">
						<?= $car['transmission']; ?>
					</div>
				</div>
			<?php //endif;?>
									
			<?php //if($car['exterior_color']):?>
				<div class="grid_12 information-item-pape">
					<div class="grid_1">
						<h4 class="wow fadeIn animated" data-wow-duration="1s" data-wow-delay="0.1s" 
						style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeIn;"> 
							color
						</h4>
					</div>
					<div class="grid_4 information-item-pape-value">
						<?= $car['exterior_color']; ?>
					</div>
				</div>
			<?php //endif;?>
			
			
			<?php //if($car['class']):?>
				<div class="grid_12 information-item-pape">
					<div class="grid_1">
						<h4 class="wow fadeIn animated" data-wow-duration="1s" data-wow-delay="0.1s" 
						style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeIn;"> 
							class
						</h4>
					</div>
					<div class="grid_4 information-item-pape-value">
						<?= $car['class']; ?>
					</div>
				</div>
			<?php //endif;?>
			
			
			<?php //if($car['category']):?>
				<div class="grid_12 information-item-pape">
					<div class="grid_1">
						<h4 class="wow fadeIn animated" data-wow-duration="1s" data-wow-delay="0.1s" 
						style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeIn;"> 
							category
						</h4>
					</div>
					<div class="grid_4 information-item-pape-value">
						<?= $car['category']; ?>
					</div>
				</div>
			<?php //endif;?>
			
			<?php //if($car['city']):?>
				<div class="grid_12 information-item-pape">
					<div class="grid_1">
						<h4 class="wow fadeIn animated" data-wow-duration="1s" data-wow-delay="0.1s" 
						style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeIn;"> 
							city
						</h4>
					</div>
					<div class="grid_4 information-item-pape-value">
						<?= $car['city']; ?>
					</div>
				</div>
			<?php //endif;?>
			
			<?php //if($car['state']):?>
				<div class="grid_12 information-item-pape">
					<div class="grid_1">
						<h4 class="wow fadeIn animated" data-wow-duration="1s" data-wow-delay="0.1s" 
						style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeIn;"> 
							state
						</h4>
					</div>
					<div class="grid_4 information-item-pape-value">
						<?= $car['state']; ?>
					</div>
				</div>
			<?php //endif;?>
			
			
			
			
			
			
			
		</div>
	</div>
	

	
	
	
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<?php

$this->registerJs('
    	
	$(".save-car").on("click", function(event){
		event.stopPropagation();
		var id = $(this).data().url;
		sendRequestSaveData(id);
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


