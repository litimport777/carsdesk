<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\Breadcrumbs;
use dosamigos\gallery\Gallery;

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
		
	<?php
		$items = [];
		for($i = 1; $i <= $car['count_images'];$i++){
			$items[($i - 1)] = [
				'url' => $this->context->getImageUrl($i, $car['hash'], $car['images_date'], false),
				'src' => $this->context->getImageUrl($i, $car['hash'], $car['images_date'], false),
				'thumbnail' => $this->context->getImageUrl($i, $car['hash'], $car['images_date'], false),
			];
		}	
	?>
	
	<div class="grid_12">
		<div class="grid_6">
			<?= dosamigos\gallery\Carousel::widget([
				'items' => $items,
				'clientEvents' => [
					'onslide' => 'function(index, slide) {
						console.log(slide);
					}'
				],
			]);?>
		</div>
		
		<div class="grid_5 item-page">
		
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


