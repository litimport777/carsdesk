<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Modal;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header id="header">
  <div class="info wow fadeIn" data-wow-duration="1s" data-wow-delay=".2s">
    <div class="width-wrapper">
      <h1>
        <a href="<?= Yii::$app->homeUrl;?>">
          <span class="wrapper logo-wrapper"><i class="fa fa-car"></i><strong>Car</strong>Sell</span>
        </a>
      </h1>
	  
      <div class="authorization-block">
        <div class="authorization">
          <a class="create" id="signup" href="<?php echo Url::to(['signup']);?>">Create an account</a>
          <span class="divider"></span>
		  <?php if(!Yii::$app->user->isGuest):?>
			  <?php echo Html::beginForm(['/site/logout'], 'post', ['id'=>'form-logout']);?>
					<?= Html::submitButton(
						'Logout (' . Yii::$app->user->identity->username . ')',
						['class' => 'logout-form']
					);?>		  
			  <?php echo Html::endForm();?>
		  <?php else:?>
				<a class="login" id="login" href="<?php echo Url::to(['/site/login']);?>">Login</a>
		  <?php endif;?>
        </div>
        <!--<span class="add btn-big" href="#"><span class="plus"></span>CAR SELL</span>-->
      </div>
    </div>
    <div class="clearfix"></div>
  </div>
  <div id="stuck_container">
    <div class="width-wrapper">
      <nav>
        <ul class="sf-menu">
          <li class="current"><a href="<?= Yii::$app->homeUrl;?>">Home</a></li>
          <li><a href="/car/search">Find a car</a>
          <li><a href="index-2.html">New cars</a></li>
			<?php //if(!Yii::$app->user->isGuest):?>
			  <li><a href="<?php echo Url::to(['site/accaunt']);?>">Accaunt</a></li>
			  <li><a href="<?php echo Url::to(['site/accaunt-save']);?>">WatchList</a></li>
			<?php //endif;?>  
         </ul>
      </nav>
      <div class="clearfix"></div>
    </div>
  </div>
 </header>



<section id="content">
  <div class="width-wrapper width-wrapper__inset1">
    <div class="wrapper1">
      <div class="container">
        <div class="row">
		
			<div class="grid_12">
				<?= Breadcrumbs::widget([
					'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
					'itemTemplate' => "<li>{link}</li> // ",
				]) ?>
				<?= Alert::widget() ?>
			</div>
			<?= $content ?>
		</div>
	  </div>
	</div>
  </div>
</section>

<!--========================================================
                          FOOTER
=========================================================-->
<footer id="footer">
  <div class="width-wrapper width-wrapper__inset1 width-wrapper__inset2">
    <div class="wrapper4">
      <div class="container">
        <div class="row">
		
		
		<?php $cnt = 1;?>
		<?php $countItemInColumns = $this->context->countItemInColumnsCityData;?>
		<?php $dataStatistic = $this->context->getStatisticToCity();?>
		<?php $cntItems = count($dataStatistic);?>

		<?php foreach ($dataStatistic as $value):?>
			<?php if((($cnt - 1) % $countItemInColumns == 0) || ($cnt == 1)):?>
				<div class="grid_3">
					<div class="box2">
						<ul class="list1">
			<?php endif;?>
							<li class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
								<?php echo Html::a($value['city'] . ' (' . $value['cnt'] . ')', '#', ['onclick'=>'return false']);?>
							</li>
			<?php if(($cnt % $countItemInColumns == 0) || ($cnt == $cntItems)):?>
						</ul>
					</div>
				</div>
			<?php endif;?>
		<?php $cnt++;?>
		<?php endforeach;?>
                  
        </div>
      </div>
    </div>
  </div>
  <div class="wrapper5">
    <div class="width-wrapper width-wrapper__inset1 width-wrapper__inset3">
      <div class="container">
        <div class="row">
          <div class="grid_12">
            <div class="privacy-block wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
              <a href="/">Car sell</a> &copy; <span id="copyright-year"></span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>


<?php //$this->render('/_registration');?>


<?php $this->endBody() ?>
</body>



</html>
<?php $this->endPage() ?>



