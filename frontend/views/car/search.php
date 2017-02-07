<?php

/* @var $this yii\web\View */

use yii\helpers\html;
use yii\helpers\url;
use yii\widgets\Breadcrumbs;
use yii\widgets\ListView;

?>
<hr />

<?php
 $this->params['breadcrumbs'] = $breadcrumbs;
?>

<hr />

<?php if(isset($result)):?>

<?php echo $sort->link('year') . ' | ' . $sort->link('price');?>

<hr />


<?php
echo ListView::widget([
	'dataProvider' => $result,
	'itemView' => '/_item',
]);
?>

<?php endif;?>