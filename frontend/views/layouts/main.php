<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
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
          <span class="wrapper"><i class="fa fa-car"></i><strong>Car</strong>Sell</span>
        </a>
      </h1>
	  
      <div class="authorization-block">
        <div class="authorization">
          <a class="create" href="#">Create an account</a>
          <span class="divider"></span>
		  <?php if(!Yii::$app->user->isGuest):?>
			  <?php echo Html::beginForm(['/site/logout'], 'post');?>
					<?= Html::submitButton(
						'Logout (' . Yii::$app->user->identity->username . ')',
						['class' => 'logout-form']
					);?>		  
			  <?php echo Html::endForm();?>
		  <?php else:?>
				<a class="login" href="<?php echo Url::to(['/site/login']);?>">Login</a>
		  <?php endif;?>
        </div>
        <a class="add btn-big" href="#"><span class="plus">+</span>Add advertisement</a>
      </div>
    </div>
    <div class="clearfix"></div>
  </div>
  <div id="stuck_container">
    <div class="width-wrapper">
      <nav>
        <ul class="sf-menu">
          <li class="current"><a href="<?= Yii::$app->homeUrl;?>">Home</a></li>
          <li><a href="<?php echo Url::to('/search');?>">Find a car</a>
          <li><a href="index-2.html">New cars</a></li>
			<?php if(!Yii::$app->user->isGuest):?>
			  <li><a href="<?php echo Url::to(['site/accaunt']);?>">Accaunt</a></li>
			  <li><a href="<?php echo Url::to(['site/accaunt-save']);?>">WatchList</a></li>
			<?php endif;?>  
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
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
		</div>
	  </div>
  </div>
</section>


<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
