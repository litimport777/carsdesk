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


