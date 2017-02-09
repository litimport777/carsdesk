<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\Breadcrumbs;

?>
<hr />

<?php
 $this->params['breadcrumbs'] = $breadcrumbs;
?>

<hr />


<h5> <?= $car['make']; ?></h5>
<div><?= $car['model'];?></div>
<div><?= $car['year']; ?></div>
<div><?= $car['price']; ?></div>

<div>
	<?php for($i = 1; $i <= $car['count_images']; $i++): ?>

		<?php echo Html::img($this->context->getImageUrl($i, $car['hash'], $car['images_date'], true));?>
		
	<?php endfor;?>
</div>

<div>
	<?php for($i = 1; $i <= $car['count_images']; $i++): ?>

		<?php echo Html::img($this->context->getImageUrl($i, $car['hash'], $car['images_date'], false));?>
		
	<?php endfor;?>
</div>


