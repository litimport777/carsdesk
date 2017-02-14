<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\Breadcrumbs;

?>

<?php
 $this->params['breadcrumbs'] = $breadcrumbs;
?>


<div  class="wrapper2 grid_11 news-items-list">

<div class="clearfix"></div>
<div class="heading1 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
	<h2>INFORMATION</h2>
</div>

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